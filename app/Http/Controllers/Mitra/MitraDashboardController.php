<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MitraDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('mitra.dashboard', compact('user'));
    }
}
