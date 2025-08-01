<?php

// app/Http/Controllers/Superadmin/LayananSatuanController.php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\LayananSatuan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;

class LayananSatuanController extends Controller
{
    public function index()
    {
        $layananSatuans = LayananSatuan::with('jenisLayanan')->get();
        return view('superadmin.layanan.satuan', compact('layananSatuans'));
    }

    public function create()
    {
        $jenisLayanans = JenisLayanan::where('nama_layanan', 'satuan')->get();
        return view('superadmin.layanan.satuan_create', compact('jenisLayanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan_id' => 'required|exists:jenis_layanan,id',
            'nama_layanan' => 'required|string|max:255',
        ]);

        LayananSatuan::create($request->all());

        return redirect()->route('superadmin.layanan-satuan.index')->with('success', 'Layanan satuan berhasil ditambahkan.');
    }

    public function edit(LayananSatuan $layananSatuan)
    {
        $jenisLayanans = JenisLayanan::where('nama_layanan', 'satuan')->get();
        return view('superadmin.layanan.satuan_edit', compact('layananSatuan', 'jenisLayanans'));
    }

    public function update(Request $request, LayananSatuan $layananSatuan)
    {
        $request->validate([
            'jenis_layanan_id' => 'required|exists:jenis_layanan,id',
            'nama_layanan' => 'required|string|max:255',
        ]);

        $layananSatuan->update($request->all());

        return redirect()->route('superadmin.layanan-satuan.index')->with('success', 'Layanan satuan berhasil diperbarui.');
    }

    public function destroy(LayananSatuan $layananSatuan)
    {
        $layananSatuan->delete();
        return redirect()->route('superadmin.layanan-satuan.index')->with('success', 'Layanan satuan berhasil dihapus.');
    }
}