<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\JamOperasional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JamOperasionalController extends Controller
{
    public function index()
    {
        $jam = JamOperasional::where('mitras_id', Auth::user()->mitra->id)->get();
        return view('mitra.jam.index', compact('jam'));
    }
}
