<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    // 1. Menampilkan semua transaksi
    public function index()
    {
        $transaksis = Pesanan::with([
            'pelangganProfile.user',
            'mitra',
            'pesananDetailKiloan.layananMitraKiloan',
            'pesananDetailSatuan.layananMitraSatuan',
        ])->latest()->get();

        return view('superadmin.transaksi.index', compact('transaksis'));
    }
}
