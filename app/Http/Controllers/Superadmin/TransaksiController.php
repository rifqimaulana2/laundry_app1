<?php
// app/Http/Controllers/Superadmin/TransaksiController.php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatTransaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = RiwayatTransaksi::with(['pesanan.user', 'pesanan.walkinCustomer', 'pesanan.mitra'])->get();
        return view('superadmin.transaksi.index', compact('transaksis'));
    }

    public function show(RiwayatTransaksi $transaksi)
    {
        $transaksi->load(['pesanan.user', 'pesanan.walkinCustomer', 'pesanan.mitra']);
        return view('superadmin.transaksi.show', compact('transaksi'));
    }
}