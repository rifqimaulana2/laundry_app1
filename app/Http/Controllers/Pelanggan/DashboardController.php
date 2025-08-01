<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $pelanggan = Auth::user()->pelangganProfile;
        $latitude = $pelanggan->latitude ?? -6.3328;
        $longitude = $pelanggan->longitude ?? 108.316;

        $totalPesanan = Pesanan::where('user_id', $userId)->count();

        // ✅ GANTI: Hitung pesanan aktif berdasarkan latest status ≠ selesai
        $pesananAktif = Pesanan::where('user_id', $userId)
            ->whereHas('latestStatus.statusMaster', function ($query) {
                $query->where('nama_status', '!=', 'selesai');
            })
            ->count();

        $tagihanBelumLunas = \App\Models\Tagihan::whereHas('pesanan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status_pembayaran', '!=', 'lunas')->sum('total_tagihan');

        $mitraFavorit = Mitra::whereHas('pesanan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->limit(3)->get();

        $mitras = Mitra::selectRaw("*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$latitude, $longitude, $latitude])
            ->orderBy('distance')
            ->get();

        return view('pelanggan.dashboard', compact(
            'mitras',
            'totalPesanan',
            'pesananAktif',
            'tagihanBelumLunas',
            'mitraFavorit'
        ));
    }
}
