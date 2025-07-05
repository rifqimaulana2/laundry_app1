<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LanggananMitraController extends Controller
{
    public function index()
    {
        $mitra = Auth::user()->mitra;
        return view('mitra.langganan.index', compact('mitra'));
    }
}
