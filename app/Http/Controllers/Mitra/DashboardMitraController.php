<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class DashboardMitraController extends Controller
{
    public function index()
    {
        $mitra = Auth::user()->mitra;

        $totalPesanan = Pesanan::where('mitras_id', $mitra->id)->count();
        $pesananBaru = Pesanan::where('mitras_id', $mitra->id)
            ->where('status_pesanan', 'baru')->count();
        $totalPendapatan = $mitra->pesanan()
            ->where('status_bayar', 'lunas')
            ->sum('total_harga');

        return view('mitra.dashboard', compact('mitra', 'totalPesanan', 'pesananBaru', 'totalPendapatan'));
    }
}
