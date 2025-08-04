<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class TrackingStatusController extends Controller
{
    public function index()
    {
        $mitraId = Auth::user()->mitra->id ?? null;

        $pesanans = Pesanan::with(['trackingStatus'])
            ->where('mitra_id', $mitraId)
            ->latest()
            ->get();

        return view('mitra.tracking_status.index', compact('pesanans'));
    }
}
