<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Pesanan::with(['pelangganProfile.user', 'mitra'])->latest()->get();
        return view('superadmin.transaksi.index', compact('transaksis'));
    }
}
