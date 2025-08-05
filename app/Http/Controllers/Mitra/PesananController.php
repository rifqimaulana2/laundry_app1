<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\WalkinCustomer;
use App\Models\LayananMitraKiloan;
use App\Models\LayananMitraSatuan;
use App\Models\User;
use App\Models\TrackingStatus;
use App\Models\StatusMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PesananController extends Controller
{
    public function index()
    {
        $mitraId = auth()->user()->mitra->id;
        $q = request('q');

        $pesanans = Pesanan::where('mitra_id', $mitraId)
            ->with(['user', 'walkinCustomer', 'tagihan', 'trackingStatus.statusMaster'])
            ->when($q, function ($query) use ($q) {
                $query->whereHas('user', fn($sub) => $sub->where('name', 'like', "%$q%"))
                      ->orWhereHas('walkinCustomer', fn($sub) => $sub->where('nama', 'like', "%$q%"));
            })
            ->latest()
            ->get();

        if (request()->ajax()) {
            return view('mitra.pesanan._table', compact('pesanans'));
        }

        return view('mitra.pesanan.index', compact('pesanans'));
    }

    public function jadwalAntarJemput()
    {
        $mitraId = auth()->user()->mitra->id;

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $jadwals = Pesanan::where('mitra_id', $mitraId)
            ->where(function ($query) use ($today, $tomorrow) {
                $query->whereDate('jadwal_jemput', $today)
                      ->orWhereDate('jadwal_antar', $today)
                      ->orWhereDate('jadwal_jemput', $tomorrow)
                      ->orWhereDate('jadwal_antar', $tomorrow);
            })
            ->orderBy('jadwal_jemput')
            ->with(['user', 'walkinCustomer'])
            ->get();

        return view('mitra.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $mitraId = auth()->user()->mitra->id;
        $walkinCustomers = WalkinCustomer::where('mitra_id', $mitraId)->get();
        $layananKiloans = LayananMitraKiloan::where('mitra_id', $mitraId)->with('layananKiloan')->get();
        $layananSatuans = LayananMitraSatuan::where('mitra_id', $mitraId)->with('layananSatuan')->get();
        $users = User::whereHas('pelanggan')->orWhereHas('pesanans', fn($q) => $q->where('mitra_id', $mitraId))->get();

        return view('mitra.pesanan.create', compact('walkinCustomers', 'layananKiloans', 'layananSatuans', 'users'));
    }

    public function store(Request $request)
    {
        $mitraId = auth()->user()->mitra->id;

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'walkin_customer_id' => 'nullable|exists:walkin_customers,id',
            'jenis_pesanan' => 'required|in:Kiloan Reguler,Kiloan Ekspres,Satuan,Kiloan + Satuan',
            'opsi_jemput' => 'required|in:Ya,Tidak',
            'jadwal_jemput' => 'required_if:opsi_jemput,Ya|date|after:now',
            'opsi_antar' => 'required|in:Ya,Tidak',
            'jadwal_antar' => 'required_if:opsi_antar,Ya|date|after:jadwal_jemput',
            'catatan_pesanan' => 'nullable|string|max:500',
            'catatan_pengiriman' => 'nullable|string|max:500',
            'opsi_pembayaran' => 'required_if:jenis_pesanan,Satuan|in:Lunas,DP',
            'layanan_mitra_kiloan_id' => 'required_if:jenis_pesanan,Kiloan Reguler,Kiloan Ekspres,Kiloan + Satuan|exists:layanan_mitra_kiloan,id',
            'berat_sementara' => 'required_if:jenis_pesanan,Kiloan Reguler,Kiloan Ekspres,Kiloan + Satuan|numeric|min:1',
            'detail_satuan' => 'nullable|array',
            'detail_satuan.*.layanan_mitra_satuan_id' => 'required_with:detail_satuan|exists:layanan_mitra_satuan,id',
            'detail_satuan.*.jumlah_item' => 'required_with:detail_satuan|integer|min:1',
        ], [
            'jadwal_jemput.after' => 'Jadwal jemput harus setelah waktu saat ini.',
            'jadwal_antar.after' => 'Jadwal antar harus setelah jadwal jemput.'
        ]);

        if ($request->jenis_pesanan === 'Kiloan Ekspres' && $request->filled('detail_satuan')) {
            return back()->withErrors(['detail_satuan' => 'Kiloan Ekspres tidak boleh memiliki detail satuan'])->withInput();
        }

        if (!$request->user_id && !$request->walkin_customer_id) {
            return back()->withErrors(['user_id' => 'Pilih pelanggan terdaftar atau walk-in.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $tipe_dp_wajib = in_array($request->jenis_pesanan, ['Kiloan Reguler', 'Kiloan Ekspres', 'Kiloan + Satuan']) ? 'Ya' : ($request->opsi_pembayaran === 'DP' ? 'Ya' : 'Tidak');
            $tipe_bisa_lunas = ($request->jenis_pesanan === 'Satuan') ? 'Ya' : 'Tidak';

            $pesanan = Pesanan::create([
                'mitra_id' => $mitraId,
                'user_id' => $request->user_id,
                'walkin_customer_id' => $request->walkin_customer_id,
                'jenis_pesanan' => $request->jenis_pesanan,
                'opsi_jemput' => $request->opsi_jemput,
                'jadwal_jemput' => $request->jadwal_jemput,
                'opsi_antar' => $request->opsi_antar,
                'jadwal_antar' => $request->jadwal_antar,
                'catatan_pesanan' => $request->catatan_pesanan,
                'catatan_pengiriman' => $request->catatan_pengiriman,
                'tipe_dp_wajib' => $tipe_dp_wajib,
                'tipe_bisa_lunas' => $tipe_bisa_lunas,
                'tanggal_pesan' => now()->toDateString(),
            ]);

            $totalTagihan = 0;

            if ($request->layanan_mitra_kiloan_id && in_array($request->jenis_pesanan, ['Kiloan Reguler', 'Kiloan Ekspres', 'Kiloan + Satuan'])) {
                $layanan = LayananMitraKiloan::findOrFail($request->layanan_mitra_kiloan_id);
                $subtotal = $request->berat_sementara * $layanan->harga_per_kg;
                $pesanan->pesanandetailKiloan()->create([
                    'layanan_mitra_kiloan_id' => $layanan->id,
                    'berat_sementara' => $request->berat_sementara,
                    'harga_per_kg' => $layanan->harga_per_kg,
                    'subtotal' => $subtotal,
                ]);
                $totalTagihan += $subtotal;
            }

            if ($request->detail_satuan && in_array($request->jenis_pesanan, ['Satuan', 'Kiloan + Satuan'])) {
                foreach ($request->detail_satuan as $detail) {
                    $layanan = LayananMitraSatuan::findOrFail($detail['layanan_mitra_satuan_id']);
                    $subtotal = $detail['jumlah_item'] * $layanan->harga_per_item;
                    $pesanan->pesanandetailSatuan()->create([
                        'layanan_mitra_satuan_id' => $layanan->id,
                        'jumlah_item' => $detail['jumlah_item'],
                        'harga_per_item' => $layanan->harga_per_item,
                        'subtotal' => $subtotal,
                    ]);
                    $totalTagihan += $subtotal;
                }
            }

            $statusPembayaran = $tipe_dp_wajib === 'Ya' ? 'belum lunas' : ($request->opsi_pembayaran === 'Lunas' ? 'lunas' : 'belum lunas');
            $pesanan->tagihan()->create([
                'total_tagihan' => $totalTagihan,
                'dp_dibayar' => 0,
                'sisa_tagihan' => $totalTagihan,
                'metode_bayar' => 'cash',
                'status_pembayaran' => $statusPembayaran,
                'jatuh_tempo_pelunasan' => now()->addDays(7),
                'waktu_bayar_dp' => $statusPembayaran === 'dp_terbayar' ? now() : null,
                'waktu_pelunasan' => $statusPembayaran === 'lunas' ? now() : null,
            ]);

            TrackingStatus::create([
                'pesanan_id' => $pesanan->id,
                'status_master_id' => StatusMaster::where('nama_status', 'menunggu_konfirmasi')->first()->id,
                'mitra_id' => $mitraId,
                'waktu' => now(),
            ]);

            DB::commit();
            return redirect()->route('mitra.pesanan.index')->with('success', 'Pesanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan pesanan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Pesanan $pesanan)
    {
        $this->authorize('view', $pesanan);
        $pesanan->load([
            'user',
            'walkinCustomer',
            'pesanandetailKiloan.layananMitraKiloan.layananKiloan',
            'pesanandetailSatuan.layananMitraSatuan.layananSatuan',
            'tagihan',
            'trackingStatus.statusMaster'
        ]);

        return view('mitra.pesanan.show', compact('pesanan'));
    }

    public function konfirmasiTimbangan(Request $request, Pesanan $pesanan)
    {
        $this->authorize('update', $pesanan);
        $request->validate([
            'berat_final' => 'required|numeric|min:0.1',
        ]);

        DB::beginTransaction();
        try {
            $detailKiloan = $pesanan->pesanandetailKiloan()->first();
            if ($detailKiloan) {
                $subtotal = $request->berat_final * $detailKiloan->harga_per_kg;
                $detailKiloan->update([
                    'berat_final' => $request->berat_final,
                    'subtotal' => $subtotal,
                ]);

                $totalTagihan = $subtotal + $pesanan->pesanandetailSatuan->sum('subtotal');
                $pesanan->tagihan()->update([
                    'total_tagihan' => $totalTagihan,
                    'sisa_tagihan' => $totalTagihan - $pesanan->tagihan->dp_dibayar,
                ]);

                TrackingStatus::create([
                    'pesanan_id' => $pesanan->id,
                    'status_master_id' => StatusMaster::where('nama_status', 'diproses')->first()->id,
                    'mitra_id' => $pesanan->mitra_id,
                    'waktu' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('mitra.pesanan.show', $pesanan)->with('success', 'Berat final berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengkonfirmasi timbangan: ' . $e->getMessage()]);
        }
    }
}
