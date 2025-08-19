<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Auth;

class RiwayatTransaksiController extends Controller
{
    /**
     * Tampilkan semua riwayat transaksi milik mitra
     */
    public function index()
    {
        $mitraId = Auth::user()->mitra->id;

        $transaksi = RiwayatTransaksi::whereHas('pesanan', function ($q) use ($mitraId) {
                $q->where('mitra_id', $mitraId);
            })
            ->with([
                'pesanan',
                'pesanan.user',
                'pesanan.walkinCustomer'
            ])
            ->latest('waktu')
            ->get();

        // ✅ arahkan ke folder view yang benar
        return view('mitra.transaksi.index', compact('transaksi'));
    }

    /**
     * Detail satu transaksi
     */
    public function show($id)
    {
        $transaksi = RiwayatTransaksi::with([
                'pesanan',
                'pesanan.user',
                'pesanan.walkinCustomer'
            ])
            ->findOrFail($id);

        // ✅ arahkan ke folder view yang benar
        return view('mitra.transaksi.show', compact('transaksi'));
    }
}
