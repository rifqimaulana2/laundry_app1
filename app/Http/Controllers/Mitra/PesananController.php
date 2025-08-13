<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\PelangganProfile;
use App\Models\WalkinCustomer;
use App\Models\Tagihan;
use App\Models\TrackingStatus;
use App\Models\PesananDetailKiloan;
use App\Models\PesananDetailSatuan;
use App\Models\StatusMaster;
use App\Models\LayananMitraKiloan;
use App\Models\LayananMitraSatuan;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $mitraId = Auth::user()->mitra->id;

        $pesanans = Pesanan::with([
            'user',
            'user.profile',
            'walkinCustomer',
            'tagihan',
            'trackingStatus.statusMaster'
        ])
        ->where('mitra_id', $mitraId)
        ->orderByDesc('created_at')
        ->get();

        return view('mitra.pesanan.index', compact('pesanans'));
    }

    public function create()
    {
        $mitraId = Auth::user()->mitra->id;

        $pelanggans = User::where('role', 'pelanggan')->with('profile')->get();
        $layananKiloan = LayananMitraKiloan::where('mitra_id', $mitraId)->with('layananKiloan')->get();
        $layananSatuan = LayananMitraSatuan::where('mitra_id', $mitraId)->with('layananSatuan')->get();

        return view('mitra.pesanan.create', compact('pelanggans', 'layananKiloan', 'layananSatuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_tipe' => 'required|in:online,walkin',
            'jenis_pesanan' => 'required|string',
            'opsi_jemput' => 'required|in:Ya,Tidak',
            'opsi_antar' => 'required|in:Ya,Tidak',
        ]);

        $mitraId = Auth::user()->mitra->id;

        if ($request->pelanggan_tipe === 'walkin') {
            $walkin = WalkinCustomer::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_tlp' => $request->no_tlp,
                'mitra_id' => $mitraId,
            ]);
            $userId = null;
            $walkinId = $walkin->id;
        } else {
            $userId = $request->user_id ?: null;
            $walkinId = null;
        }

        $pesanan = Pesanan::create([
            'user_id' => $userId,
            'walkin_customer_id' => $walkinId,
            'mitra_id' => $mitraId,
            'jenis_pesanan' => $request->jenis_pesanan,
            'catatan_pesanan' => $request->catatan_pesanan,
            'tipe_dp_wajib' => $request->tipe_dp_wajib ?? 'Tidak',
            'tipe_bisa_lunas' => $request->tipe_bisa_lunas ?? 'Tidak',
            'tanggal_pesan' => now()->toDateString(),
            'opsi_jemput' => $request->opsi_jemput,
            'jadwal_jemput' => $request->jadwal_jemput,
            'opsi_antar' => $request->opsi_antar,
            'jadwal_antar' => $request->jadwal_antar,
            'catatan_pengiriman' => $request->catatan_pengiriman,
        ]);

        // Pesanan Detail Kiloan
        if (in_array($request->jenis_pesanan, ['Kiloan', 'Kiloan + Satuan']) && $request->has('kiloan')) {
            foreach ($request->kiloan as $k) {
                if (empty($k['layanan_id']) || empty($k['berat'])) continue;
                PesananDetailKiloan::create([
                    'pesanan_id' => $pesanan->id,
                    'layanan_mitra_kiloan_id' => $k['layanan_id'],
                    'berat_sementara' => $k['berat'],
                    'harga_per_kg' => $k['harga'] ?? 0,
                    'subtotal' => ($k['berat'] * ($k['harga'] ?? 0)),
                ]);
            }
        }

        // Pesanan Detail Satuan
        if (in_array($request->jenis_pesanan, ['Satuan', 'Kiloan + Satuan']) && $request->has('satuan')) {
            foreach ($request->satuan as $s) {
                if (empty($s['layanan_id']) || empty($s['jumlah'])) continue;
                PesananDetailSatuan::create([
                    'pesanan_id' => $pesanan->id,
                    'layanan_mitra_satuan_id' => $s['layanan_id'],
                    'jumlah_item' => $s['jumlah'],
                    'harga_per_item' => $s['harga'] ?? 0,
                    'subtotal' => ($s['jumlah'] * ($s['harga'] ?? 0)),
                ]);
            }
        }

        // Hitung total tagihan
        $pesanan->load('kiloanDetails', 'satuanDetails');
        $total = $pesanan->kiloanDetails->sum('subtotal') + $pesanan->satuanDetails->sum('subtotal');

        Tagihan::create([
            'pesanan_id' => $pesanan->id,
            'total_tagihan' => $total,
            'dp_dibayar' => $request->dp_dibayar ?? 0,
            'sisa_tagihan' => $total - ($request->dp_dibayar ?? 0),
            'metode_bayar' => $request->metode_bayar ?? 'transfer',
            'status_pembayaran' => ($request->dp_dibayar ?? 0) >= $total
                ? 'lunas'
                : (($request->dp_dibayar ?? 0) > 0 ? 'dp_terbayar' : 'belum lunas'),
            'jatuh_tempo_pelunasan' => $request->jatuh_tempo ?? null,
            'waktu_bayar_dp' => $request->dp_dibayar ? now() : null,
        ]);

        // Status awal tracking
        $statusAwal = StatusMaster::where('nama_status', 'menunggu_konfirmasi')->first();
        TrackingStatus::create([
            'pesanan_id' => $pesanan->id,
            'status_master_id' => $statusAwal ? $statusAwal->id : 1,
            'waktu' => now(),
            'user_id' => Auth::id(),
            'mitra_id' => $mitraId,
            'pesan' => 'Pesanan dibuat oleh mitra',
        ]);

        return redirect()->route('mitra.pesanan.show', $pesanan->id)->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show($id)
    {
        $mitraId = Auth::user()->mitra->id;

        $pesanan = Pesanan::with([
            'user.profile',
            'walkinCustomer',
            'kiloanDetails.layananMitraKiloan.layananKiloan',
            'satuanDetails.layananMitraSatuan.layananSatuan',
            'tagihan',
            'trackingStatus.statusMaster',
            'riwayatTransaksi'
        ])
        ->where('mitra_id', $mitraId)
        ->findOrFail($id);

        $statusList = StatusMaster::all();

        return view('mitra.pesanan.show', compact('pesanan', 'statusList'));
    }

    public function jadwal()
    {
        $mitraId = Auth::user()->mitra->id;

        $jadwal = Pesanan::with(['user.profile', 'walkinCustomer', 'trackingStatus.statusMaster'])
            ->where('mitra_id', $mitraId)
            ->where(function($q){
                $q->where('opsi_jemput', 'Ya')
                  ->orWhere('opsi_antar', 'Ya');
            })
            ->orderBy('jadwal_jemput')
            ->orderBy('jadwal_antar')
            ->get();

        return view('mitra.pesanan.jadwal', compact('jadwal'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_master_id' => 'required|exists:status_master,id',
        ]);

        TrackingStatus::create([
            'pesanan_id' => $id,
            'status_master_id' => $request->status_master_id,
            'waktu' => now(),
            'user_id' => Auth::id(),
            'mitra_id' => Auth::user()->mitra->id,
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function konfirmasiTimbangan(Request $request, $id)
    {
        $request->validate([
            'berat_real' => 'required|numeric|min:0.1',
        ]);

        $pesananDetail = PesananDetailKiloan::where('pesanan_id', $id)->firstOrFail();
        $pesananDetail->berat_real = $request->berat_real;
        $pesananDetail->subtotal = $pesananDetail->berat_real * $pesananDetail->harga_per_kg;
        $pesananDetail->save();

        // Update total tagihan
        $pesanan = Pesanan::with('kiloanDetails', 'satuanDetails')->findOrFail($id);
        $total = $pesanan->kiloanDetails->sum('subtotal') + $pesanan->satuanDetails->sum('subtotal');

        $pesanan->tagihan->update([
            'total_tagihan' => $total,
            'sisa_tagihan' => $total - $pesanan->tagihan->dp_dibayar,
        ]);

        // Tambah tracking status
        $statusTimbang = StatusMaster::where('nama_status', 'timbangan_dikonfirmasi')->first();
        TrackingStatus::create([
            'pesanan_id' => $id,
            'status_master_id' => $statusTimbang ? $statusTimbang->id : 1,
            'waktu' => now(),
            'user_id' => Auth::id(),
            'mitra_id' => Auth::user()->mitra->id,
            'pesan' => 'Berat real laundry telah dikonfirmasi oleh mitra',
        ]);

        return back()->with('success', 'Timbangan real berhasil dikonfirmasi.');
    }
}
