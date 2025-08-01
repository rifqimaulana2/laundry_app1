<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        $mitraId = auth()->user()->mitra->id;
        $transaksis = Tagihan::where('status_pembayaran', 'lunas')
            ->whereHas('pesanan', function ($query) use ($mitraId) {
                $query->where('mitra_id', $mitraId);
            })->with(['pesanan.user', 'pesanan.walkinCustomer'])->get();
        return view('mitra.transaksi.index', compact('transaksis'));
    }

    public function show(Tagihan $transaksi)
    {
        $this->authorize('view', $transaksi);
        $transaksi->load(['pesanan.user', 'pesanan.walkinCustomer', 'pesanan.pesananDetailKiloan', 'pesanan.pesananDetailSatuan']);
        return view('mitra.transaksi.show', compact('transaksi'));
    }
}
?>