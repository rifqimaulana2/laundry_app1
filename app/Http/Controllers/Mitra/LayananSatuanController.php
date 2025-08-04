<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\LayananMitraSatuan;
use App\Models\LayananSatuan;
use Illuminate\Http\Request;

class LayananSatuanController extends Controller
{
    public function index()
    {
        $mitraId = auth()->user()->mitra->id;
        $layananSatuans = LayananMitraSatuan::where('mitra_id', $mitraId)->with('layananSatuan')->get();
        return view('mitra.layanan.satuan.index', compact('layananSatuans'));
    }

    public function create()
    {
        $layananSatuans = LayananSatuan::all();
        return view('mitra.layanan.satuan.create', compact('layananSatuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_satuan_id' => 'required|exists:layanan_satuan,id',
            'harga_per_item' => 'required|numeric|min:0',
            'durasi_hari' => 'required|integer|min:1',
        ]);

        LayananMitraSatuan::create([
            'mitra_id' => auth()->user()->mitra->id,
            'layanan_satuan_id' => $request->layanan_satuan_id,
            'harga_per_item' => $request->harga_per_item,
            'durasi_hari' => $request->durasi_hari,
        ]);

        return redirect()->route('mitra.layanan-satuan.index')->with('success', 'Layanan satuan berhasil ditambahkan.');
    }

    public function edit(LayananMitraSatuan $layananSatuan)
    {
        $this->authorize('update', $layananSatuan);
        $layananSatuans = LayananSatuan::all();
        return view('mitra.layanan.satuan.edit', compact('layananSatuan', 'layananSatuans'));
    }

    public function update(Request $request, LayananMitraSatuan $layananSatuan)
    {
        $this->authorize('update', $layananSatuan);
        $request->validate([
            'layanan_satuan_id' => 'required|exists:layanan_satuan,id',
            'harga_per_item' => 'required|numeric|min:0',
            'durasi_hari' => 'required|integer|min:1',
        ]);

        $layananSatuan->update([
            'layanan_satuan_id' => $request->layanan_satuan_id,
            'harga_per_item' => $request->harga_per_item,
            'durasi_hari' => $request->durasi_hari,
        ]);

        return redirect()->route('mitra.layanan-satuan.index')->with('success', 'Layanan satuan berhasil diperbarui.');
    }

    public function destroy(LayananMitraSatuan $layananSatuan)
    {
        $this->authorize('delete', $layananSatuan);
        $layananSatuan->delete();
        return redirect()->route('mitra.layanan-satuan.index')->with('success', 'Layanan satuan berhasil dihapus.');
    }
}