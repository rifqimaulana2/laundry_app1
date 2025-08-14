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
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Daftar pesanan mitra
     */
    public function index()
    {
        $mitraId = Auth::user()->mitra->id;

        $pesanans = Pesanan::with([
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

    /**
     * Form tambah pesanan
     */
    public function create()
    {
        $mitraId = Auth::user()->mitra->id;

        $pelanggans = User::where('role', 'pelanggan')->with('profile')->get();
        $walkinCustomers = WalkinCustomer::where('mitra_id', $mitraId)->get();
        $layananKiloan = LayananMitraKiloan::where('mitra_id', $mitraId)->with('layananKiloan')->get();
        $layananSatuan = LayananMitraSatuan::where('mitra_id', $mitraId)->with('layananSatuan')->get();

        return view('mitra.pesanan.create', compact('pelanggans', 'walkinCustomers', 'layananKiloan', 'layananSatuan'));
    }

    /**
     * Simpan pesanan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_tipe' => 'required|in:online,walkin,walkin_existing',
            'jenis_pesanan' => 'required|string',
            'opsi_jemput' => 'required|in:Ya,Tidak',
            'opsi_antar' => 'required|in:Ya,Tidak',
        ]);

        $mitraId = Auth::user()->mitra->id;

        if ($request->pelanggan_tipe === 'walkin') {
    // Validasi khusus pelanggan walk-in baru
    $request->validate([
        'nama'   => 'required|string|max:255',
        'alamat' => 'required|string|max:500',
        'no_tlp' => 'required|string|max:20',
    ]);

    // Buat pelanggan walk-in baru
    $walkin = WalkinCustomer::create([
        'nama'     => $request->nama,
        'alamat'   => $request->alamat,
        'no_tlp'   => $request->no_tlp,
        'mitra_id' => $mitraId,
    ]);

    $userId   = null;
    $walkinId = $walkin->id;

} elseif ($request->pelanggan_tipe === 'walkin_existing') {
    // Validasi id pelanggan walk-in existing
    $request->validate([
        'walkin_customer_id' => 'required|exists:walkin_customers,id'
    ]);

    $walkinId = $request->walkin_customer_id;
    $userId   = null;

} else {
    // Validasi pelanggan online terdaftar
    $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    $userId   = $request->user_id;
    $walkinId = null;
}


       $pesanan = Pesanan::create([
    'user_id' => $userId,
    'walkin_customer_id' => $walkinId,
    'mitra_id' => $mitraId,
    'jenis_pesanan' => trim($request->jenis_pesanan), // pastikan string valid
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
    'order_id' => 'DP-' . $pesanan->id . '-' . uniqid(), // generate unik
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

    /**
     * Detail pesanan
     */
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

    /**
     * Jadwal antar jemput
     */
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

    /**
     * Update status tracking
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_master_id' => 'required|exists:status_master,id',
            'pesan' => 'nullable|string|max:500',
        ]);

        TrackingStatus::create([
            'pesanan_id' => $id,
            'status_master_id' => $request->status_master_id,
            'waktu' => now(),
            'user_id' => Auth::id(),
            'mitra_id' => Auth::user()->mitra->id,
            'pesan' => $request->pesan
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Konfirmasi timbangan real
     */
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

    /**
     * Daftar tagihan
     */
    public function tagihanIndex()
    {
        $mitraId = Auth::user()->mitra->id;

        $tagihans = Tagihan::whereHas('pesanan', function($q) use ($mitraId) {
                $q->where('mitra_id', $mitraId);
            })
            ->with(['pesanan.user.pelangganProfile', 'pesanan.walkinCustomer'])
            ->latest()
            ->get();

        return view('mitra.transaksi.index', compact('tagihans'));
    }

    /**
     * Form pelunasan
     */
    public function pelunasan($id)
    {
        $mitraId = Auth::user()->mitra->id;

        $pesanan = Pesanan::with('tagihan')
            ->where('mitra_id', $mitraId)
            ->findOrFail($id);

        if (!$pesanan->tagihan || $pesanan->tagihan->sisa_tagihan <= 0) {
            return redirect()->route('mitra.transaksi.index')
                ->with('error', 'Tagihan sudah lunas atau tidak ditemukan.');
        }

        return view('mitra.transaksi.pelunasan', compact('pesanan'));
    }

    /**
     * Proses pelunasan
     */
    public function prosesPelunasan(Request $request, $id)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode_bayar' => 'required|in:transfer,tunai'
        ]);

        $mitraId = Auth::user()->mitra->id;

        $pesanan = Pesanan::with('tagihan')
            ->where('mitra_id', $mitraId)
            ->findOrFail($id);

        $tagihan = $pesanan->tagihan;
        if (!$tagihan) {
            return back()->with('error', 'Tagihan tidak ditemukan.');
        }

        $jumlahBayar = min($request->jumlah_bayar, $tagihan->sisa_tagihan);

        // Update tagihan
        $tagihan->dp_dibayar += $jumlahBayar;
        $tagihan->sisa_tagihan -= $jumlahBayar;
        $tagihan->status_pembayaran = $tagihan->sisa_tagihan <= 0 ? 'lunas' : 'dp_terbayar';
        if ($tagihan->sisa_tagihan <= 0) $tagihan->sisa_tagihan = 0;
        $tagihan->save();

        // Simpan riwayat transaksi
        RiwayatTransaksi::create([
            'pesanan_id' => $pesanan->id,
            'jumlah_transaksi' => $jumlahBayar,
            'metode_bayar' => $request->metode_bayar,
            'status_transaksi' => 'berhasil',
            'waktu_transaksi' => now(),
            'keterangan' => 'Pelunasan tagihan oleh mitra',
            'user_id' => Auth::id(),
            'mitra_id' => $mitraId,
        ]);

        return redirect()->route('mitra.transaksi.show', $pesanan->id)
            ->with('success', 'Pelunasan berhasil dicatat.');
    }

    /**
     * Pembayaran tambahan dari detail pesanan
     */
    public function storePembayaran(Request $request, $tagihanId)
    {
        $request->validate([
            'jumlah_transaksi' => 'required|numeric|min:1',
            'metode_bayar' => 'required|in:transfer,tunai'
        ]);

        $mitraId = Auth::user()->mitra->id;

        $tagihan = Tagihan::with('pesanan')
            ->whereHas('pesanan', function($q) use ($mitraId) {
                $q->where('mitra_id', $mitraId);
            })
            ->findOrFail($tagihanId);

        $jumlahBayar = min($request->jumlah_transaksi, $tagihan->sisa_tagihan);

        $tagihan->dp_dibayar += $jumlahBayar;
        $tagihan->sisa_tagihan -= $jumlahBayar;
        $tagihan->status_pembayaran = $tagihan->sisa_tagihan <= 0 ? 'lunas' : 'dp_terbayar';
        if ($tagihan->sisa_tagihan <= 0) $tagihan->sisa_tagihan = 0;
        $tagihan->save();

        RiwayatTransaksi::create([
            'pesanan_id' => $tagihan->pesanan->id,
            'jumlah_transaksi' => $jumlahBayar,
            'metode_bayar' => $request->metode_bayar,
            'status_transaksi' => 'berhasil',
            'waktu_transaksi' => now(),
            'keterangan' => 'Pembayaran tambahan dari halaman pesanan.show',
            'user_id' => Auth::id(),
            'mitra_id' => $mitraId,
        ]);

        return redirect()->route('mitra.pesanan.show', $tagihan->pesanan->id)
            ->with('success', 'Pembayaran berhasil ditambahkan.');
    }
}
