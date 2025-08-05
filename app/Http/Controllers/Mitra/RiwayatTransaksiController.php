<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\RiwayatTransaksi;
use Illuminate\Http\Request;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        $mitraId = auth()->user()->mitra->id;
        $transaksis = RiwayatTransaksi::whereHas('pesanan', fn($q) => $q->where('mitra_id', $mitraId))
            ->with(['pesanan.user', 'pesanan.walkinCustomer'])
            ->latest()
            ->get();

        return view('mitra.transaksi.index', compact('transaksis'));
    }

    public function show(RiwayatTransaksi $transaksi)
    {
        $this->authorize('view', $transaksi->pesanan);
        $transaksi->load([
            'pesanan.user',
            'pesanan.walkinCustomer',
            'pesanan.pesananDetailKiloan.layananMitraKiloan.layananKiloan',
            'pesanan.pesananDetailSatuan.layananMitraSatuan.layananSatuan',
            'pesanan.tagihan'
        ]);

        return view('mitra.transaksi.show', compact('transaksi'));
    }
}