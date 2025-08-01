<?php
// app/Http/Controllers/Superadmin/PesananController.php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['user', 'walkinCustomer', 'mitra', 'pesananDetailKiloan', 'pesananDetailSatuan'])->get();
        return view('superadmin.pesanan.index', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load(['user', 'walkinCustomer', 'mitra', 'pesananDetailKiloan', 'pesananDetailSatuan', 'tagihan']);
        return view('superadmin.pesanan.show', compact('pesanan'));
    }
}