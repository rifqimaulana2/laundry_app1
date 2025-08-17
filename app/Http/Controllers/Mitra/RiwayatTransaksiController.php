<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Auth;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        $mitraId = Auth::user()->mitra->id;

        $transaksi = RiwayatTransaksi::where('mitra_id', $mitraId)
            ->with(['pesanan.user', 'pesanan.walkinCustomer'])
            ->latest()
            ->get();

        return view('mitra.transaksi.index', compact('transaksi'));
    }

    public function show($id)
    {
        $transaksi = RiwayatTransaksi::with('pesanan')->findOrFail($id);
        return view('mitra.transaksi.show', compact('transaksi'));
    }
}
