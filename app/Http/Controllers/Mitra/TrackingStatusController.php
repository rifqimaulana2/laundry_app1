<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\StatusMaster;
use App\Models\TrackingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrackingStatusController extends Controller
{
    public function index()
    {
        $mitraId = Auth::user()->mitra->id;
        $pesanans = Pesanan::with(['trackingStatus.statusMaster', 'user', 'walkinCustomer'])
            ->where('mitra_id', $mitraId)
            ->latest()
            ->get();

        return view('mitra.tracking_status.index', compact('pesanans'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $this->authorize('update', $pesanan);
        $request->validate([
            'status_master_id' => 'required|exists:status_master,id',
            'pesan' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            TrackingStatus::create([
                'pesanan_id' => $pesanan->id,
                'status_master_id' => $request->status_master_id,
                'mitra_id' => $pesanan->mitra_id,
                'pesan' => $request->pesan,
                'waktu' => now(),
            ]);

            DB::commit();
            return redirect()->route('mitra.tracking_status.index')->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui status: ' . $e->getMessage()]);
        }
    }
}