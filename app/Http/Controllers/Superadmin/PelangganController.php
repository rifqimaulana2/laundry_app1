<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PelangganProfile;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = PelangganProfile::with('user')->get();
        return view('superadmin.pelanggan.index', compact('pelanggans'));
    }
}
