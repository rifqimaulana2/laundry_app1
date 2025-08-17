<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrackingStatus;
use Illuminate\Support\Facades\Auth;

class TrackingStatusController extends Controller
{
    public function store(Request $request, $pesananId)
    {
        $request->validate([
            'status_master_id' => 'required|exists:status_master,id',
            'pesan' => 'nullable|string|max:500',
        ]);

        TrackingStatus::create([
            'pesanan_id' => $pesananId,
            'status_master_id' => $request->status_master_id,
            'waktu' => now(),
            'user_id' => Auth::id(),
            'mitra_id' => Auth::user()->mitra->id,
            'pesan' => $request->pesan
        ]);

        return back()->with('success', 'Status berhasil ditambahkan.');
    }
}
