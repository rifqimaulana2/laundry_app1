<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\LayananKiloan;
use App\Models\LayananSatuan;

class LayananController extends Controller
{
    public function index()
    {
        $layananKiloans = LayananKiloan::all();
        $layananSatuans = LayananSatuan::all();

        return view('superadmin.layanan.index', compact('layananKiloans', 'layananSatuans'));
    }
}
