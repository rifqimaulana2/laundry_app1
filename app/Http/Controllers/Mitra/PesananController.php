<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\WalkinCustomer;
use App\Models\LayananMitraKiloan;
use App\Models\LayananMitraSatuan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $mitraId = auth()->user()->mitra->id;
        $q = request('q');
        $pesanans = Pesanan::where('mitra_id', $mitraId)
            ->with(['user', 'walkinCustomer', 'tagihan'])
            ->when($q, function($query) use ($q) {
                $query->whereHas('user', function($sub) use ($q) {
                    $sub->where('name', 'like', "$q%");
                })->orWhereHas('walkinCustomer', function($sub) use ($q) {
                    $sub->where('nama', 'like', "$q%");
                });
            })
            ->get();
        if (request()->ajax()) {
            return view('mitra.pesanan._table', compact('pesanans'));
        }
        return view('mitra.pesanan.index', compact('pesanans'));
    }

    public function create()
    {
        $mitraId = auth()->user()->mitra->id;
        $walkinCustomers = WalkinCustomer::where('mitra_id', $mitraId)->get();
        $layananKiloans = LayananMitraKiloan::where('mitra_id', $mitraId)->get();
        $layananSatuans = LayananMitraSatuan::where('mitra_id', $mitraId)->get();
        return view('mitra.pesanan.create', compact('walkinCustomers', 'layananKiloans', 'layananSatuans'));
    }

    public function store(Request $request)
    {
        $mitraId = auth()->user()->mitra->id;
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'walkin_customer_id' => 'nullable|exists:walkin_customers,id',
            'jenis_pesanan' => 'required|in:Kiloan,Satuan,Gabungan',
            'opsi_jemput' => 'required|in:Ya,Tidak',
            'jadwal_jemput' => 'required_if:opsi_jemput,Ya|date',
            'opsi_antar' => 'required|in:Ya,Tidak',
            'jadwal_antar' => 'required_if:opsi_antar,Ya|date',
            'catatan_pesanan' => 'nullable|string',
            'catatan_pengiriman' => 'nullable|string',
            'detail_kiloan' => 'nullable|array',
            'detail_kiloan.*.layanan_mitra_kiloan_id' => 'required_with:detail_kiloan|exists:layanan_mitra_kiloan,id',
            'detail_kiloan.*.berat_sementara' => 'required_with:detail_kiloan|numeric|min:0',
            'detail_satuan' => 'nullable|array',
            'detail_satuan.*.layanan_mitra_satuan_id' => 'required_with:detail_satuan|exists:layanan_mitra_satuan,id',
            'detail_satuan.*.jumlah_item' => 'required_with:detail_satuan|integer|min:1',
        ]);

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
            'tanggal_pesan' => now(),
        ]);

        if ($request->detail_kiloan) {
            foreach ($request->detail_kiloan as $detail) {
                $pesanan->pesananDetailKiloan()->create([
                    'layanan_mitra_kiloan_id' => $detail['layanan_mitra_kiloan_id'],
                    'berat_sementara' => $detail['berat_sementara'],
                    'harga_per_kg' => LayananMitraKiloan::find($detail['layanan_mitra_kiloan_id'])->harga_per_kg,
                ]);
            }
        }

        if ($request->detail_satuan) {
            foreach ($request->detail_satuan as $detail) {
                $pesanan->pesananDetailSatuan()->create([
                    'layanan_mitra_satuan_id' => $detail['layanan_mitra_satuan_id'],
                    'jumlah_item' => $detail['jumlah_item'],
                    'harga_per_item' => LayananMitraSatuan::find($detail['layanan_mitra_satuan_id'])->harga_per_item,
                ]);
            }
        }

        // Buat tagihan
        $pesanan->tagihan()->create([
            'metode_bayar' => 'cash',
            'status_pembayaran' => 'belum lunas',
            'jatuh_tempo_pelunasan' => now()->addDays(7),
        ]);

        return redirect()->route('mitra.pesanan.index')->with('success', 'Pesanan berhasil ditambahkan.');
    }

    public function show(Pesanan $pesanan)
    {
        $this->authorize('view', $pesanan);
        $pesanan->load(['user', 'walkinCustomer', 'pesananDetailKiloan', 'pesananDetailSatuan', 'tagihan']);
        return view('mitra.pesanan.show', compact('pesanan'));
    }
}
?>