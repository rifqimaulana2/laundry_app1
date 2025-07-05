<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\TagihanPembayaran;

class TagihanPembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    // 1. Tampilkan semua tagihan pembayaran
    public function index()
    {
        $tagihans = TagihanPembayaran::with([
            'pesanan.pelangganProfile.user',
            'pesanan.mitra.user'
        ])->latest()->get();

        return view('superadmin.tagihan.index', compact('tagihans'));
    }
}
