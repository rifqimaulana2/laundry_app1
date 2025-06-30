<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PaketLangganan;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = PaketLangganan::all();
        return view('superadmin.paket.index', compact('pakets'));
    }
}
