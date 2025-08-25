<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::with(['mitra', 'user'])->latest()->get();
        return view('superadmin.laporan.index', compact('laporans'));
    }

    public function rekap()
    {
        $rekap = Laporan::selectRaw('mitra_id,
                COUNT(*) as total_laporan,
                SUM(CASE WHEN status = "diterima" THEN 1 ELSE 0 END) as laporan_diterima,
                SUM(CASE WHEN status = "ditolak" THEN 1 ELSE 0 END) as laporan_ditolak,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as laporan_pending')
            ->groupBy('mitra_id')
            ->with('mitra')
            ->get();

        return view('superadmin.laporan.rekap', compact('rekap'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak'
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}
