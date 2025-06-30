<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\LanggananMitra;
use App\Models\PesananDetailKiloan;
use App\Models\PesananDetailSatuan;

class DashboardMitraController extends Controller
{
    public function index()
    {
        $mitraId = Auth::id();

        // Hitung status pesanan
        $totalPesanan = Pesanan::where('mitra_id', $mitraId)->count();
        $diproses     = Pesanan::where('mitra_id', $mitraId)->where('status_pesanan', 'diproses')->count();
        $selesai      = Pesanan::where('mitra_id', $mitraId)->where('status_pesanan', 'selesai')->count();
        $dibatalkan   = Pesanan::where('mitra_id', $mitraId)->where('status_pesanan', 'batal')->count();

        // Langganan mitra
        $langganan = LanggananMitra::where('mitra_id', $mitraId)->latest()->first();

        // 🔧 Data Satuan: group by nama_layanan (via relasi)
        $satuan = PesananDetailSatuan::with('layanan')
            ->whereHas('pesanan', fn($q) => $q->where('mitra_id', $mitraId))
            ->get()
            ->groupBy(fn($item) => $item->layanan->nama_layanan ?? 'Tidak Diketahui')
            ->map(fn($items) => $items->count());

        // 🔧 Data Kiloan: group by jenis_layanan (via relasi)
        $kiloan = PesananDetailKiloan::with('layanan')
            ->whereHas('pesanan', fn($q) => $q->where('mitra_id', $mitraId))
            ->get()
            ->groupBy(fn($item) => $item->layanan->jenis_layanan ?? 'Tidak Diketahui')
            ->map(fn($items) => $items->count());

        // Gabungkan dua data
        $combined = $satuan->mergeRecursive($kiloan);

        return view('mitra.dashboard', [
            'totalPesanan'    => $totalPesanan,
            'diproses'        => $diproses,
            'selesai'         => $selesai,
            'dibatalkan'      => $dibatalkan,
            'statusLangganan' => $langganan->status ?? null,
            'berlakuSampai'   => optional($langganan)->berlaku_sampai,
            'layananLabels'   => $combined->keys(),
            'layananData'     => $combined->values()
        ]);
    }
}
