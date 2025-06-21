<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\Pesanan;

class HomeController extends Controller
{
    public function index()
    {
        $mitras = Mitra::take(10)->get();
        return view('pages.home', compact('mitras'));
    }

    public function track(Request $request)
    {
        $kode = $request->kode;
        $status = null;

        if ($kode) {
            $status = Pesanan::where('kode', $kode)->first();
        }

        return view('pages.pelacakan', compact('status'));
    }
}
