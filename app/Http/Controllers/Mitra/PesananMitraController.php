<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananMitraController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['user', 'walkinCustomer', 'pesananDetailKiloan', 'pesananDetailSatuan'])
            ->where('mitras_id', Auth::user()->mitra->id)
            ->latest()
            ->get();

        return view('mitra.pesanan.index', compact('pesanan'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'walkinCustomer', 'pesananDetailKiloan', 'pesananDetailSatuan'])
            ->where('mitras_id', Auth::user()->mitra->id)
            ->findOrFail($id);

        return view('mitra.pesanan.show', compact('pesanan'));
    }
}
