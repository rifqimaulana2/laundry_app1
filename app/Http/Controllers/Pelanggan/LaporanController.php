<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;
use App\Models\Mitra;

class LaporanController extends Controller
{
    /**
     * Tampilkan form laporan
     */
    public function create()
    {
        $mitras = Mitra::all();
        return view('pelanggan.laporan.create', compact('mitras'));
    }

    /**
     * Simpan laporan
     */
    public function store(Request $request)
    {
        $request->validate([
            'mitra_id'   => 'required|exists:mitras,id',
            'deskripsi'  => 'required|string|max:500',
            'bukti'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('laporan_bukti', 'public');
        }

        Laporan::create([
            'user_id'     => Auth::id(),
            'mitra_id'    => $request->mitra_id,
            'deskripsi'   => $request->deskripsi,
            'bukti'       => $buktiPath,
            'status'      => 'pending',
        ]);

        // ✅ Setelah simpan, balik ke form create dengan pesan sukses
        return redirect()->route('pelanggan.laporan.create')
            ->with('success', 'Laporan berhasil dikirim ke admin.');
    }
}
