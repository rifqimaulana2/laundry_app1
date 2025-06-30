<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\JamOperasional;
use Illuminate\Support\Facades\Auth;

class JamOperasionalController extends Controller
{
    public function index()
    {
        $jam = JamOperasional::where('mitra_id', Auth::id())->get();

        return view('mitra.jam-operasional.index', compact('jam'));
    }
}
