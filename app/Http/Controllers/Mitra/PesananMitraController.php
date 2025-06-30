<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananMitraController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with('user')
            ->where('mitra_id', Auth::id())
            ->latest()
            ->get();

        return view('mitra.pesanan.index', compact('pesanan'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'detailSatuan', 'detailKiloan'])
            ->where('mitra_id', Auth::id())
            ->findOrFail($id);

        return view('mitra.pesanan.show', compact('pesanan'));
    }
}
