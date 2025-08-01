<?php
// app/Http/Controllers/Superadmin/TagihanController.php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::with(['pesanan.user', 'pesanan.walkinCustomer', 'pesanan.mitra'])->get();
        return view('superadmin.tagihan.index', compact('tagihans'));
    }

    public function show(Tagihan $tagihan)
    {
        $tagihan->load(['pesanan.user', 'pesanan.walkinCustomer', 'pesanan.mitra', 'pesanan.pesananDetailKiloan', 'pesanan.pesananDetailSatuan']);
        return view('superadmin.tagihan.show', compact('tagihan'));
    }
}