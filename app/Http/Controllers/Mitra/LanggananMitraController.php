<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\LanggananMitra;
use Illuminate\Support\Facades\Auth;

class LanggananMitraController extends Controller
{
    public function index()
    {
        $langganan = LanggananMitra::where('mitra_id', Auth::id())->latest()->first();

        return view('mitra.langganan.index', compact('langganan'));
    }
}
