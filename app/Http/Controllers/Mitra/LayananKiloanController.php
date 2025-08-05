<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\LayananMitraKiloan;
use App\Models\LayananKiloan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;

class LayananKiloanController extends Controller
{
    public function index()
    {
        $mitra = auth()->user()->mitra;
        if (!$mitra) abort(403, 'Mitra tidak ditemukan.');

        $layananKiloans = LayananMitraKiloan::where('mitra_id', $mitra->id)
            ->with(['layananKiloan', 'layananKiloan.jenisLayanan'])
            ->get();

        return view('mitra.layanan.kiloan.index', compact('layananKiloans'));
    }

    public function create()
    {
        $layananKiloans = LayananKiloan::with('jenisLayanan')->get();
        return view('mitra.layanan.kiloan.create', compact('layananKiloans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_kiloan_id' => 'required|exists:layanan_kiloan,id',
            'harga_per_kg' => 'required|numeric|min:0',
            'durasi_hari' => 'required|integer|min:1',
        ]);

        $mitra = auth()->user()->mitra;
        if (!$mitra) abort(403, 'Mitra tidak ditemukan.');

        LayananMitraKiloan::create([
            'mitra_id' => $mitra->id,
            'layanan_kiloan_id' => $request->layanan_kiloan_id,
            'harga_per_kg' => $request->harga_per_kg,
            'durasi_hari' => $request->durasi_hari,
        ]);

        return redirect()->route('mitra.layanan-kiloan.index')->with('success', 'Layanan kiloan berhasil ditambahkan.');
    }

    public function edit(LayananMitraKiloan $layananKiloan)
{
    $mitra = auth()->user()->mitra;
    if (!$mitra || $mitra->id !== $layananKiloan->mitra_id) {
        abort(403, 'Unauthorized action.');
    }
    $layananKiloans = LayananKiloan::with('jenisLayanan')->get();
    return view('mitra.layanan.kiloan.edit', compact('layananKiloan', 'layananKiloans'));
}

    public function update(Request $request, LayananMitraKiloan $layananKiloan)
    {
        $this->authorize('update', $layananKiloan);

        $request->validate([
            'layanan_kiloan_id' => 'required|exists:layanan_kiloan,id',
            'harga_per_kg' => 'required|numeric|min:0',
            'durasi_hari' => 'required|integer|min:1',
        ]);

        $layananKiloan->update($request->only(['layanan_kiloan_id', 'harga_per_kg', 'durasi_hari']));

        return redirect()->route('mitra.layanan-kiloan.index')->with('success', 'Layanan kiloan berhasil diperbarui.');
    }

    public function destroy(LayananMitraKiloan $layananKiloan)
    {
        $this->authorize('delete', $layananKiloan);
        $layananKiloan->delete();
        return redirect()->route('mitra.layanan-kiloan.index')->with('success', 'Layanan kiloan berhasil dihapus.');
    }
}