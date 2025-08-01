<?php

// app/Http/Controllers/Superadmin/JenisLayananController.php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;

class JenisLayananController extends Controller
{
    public function index()
    {
        $jenisLayanans = JenisLayanan::all();
        return view('superadmin.jenis_layanan.index', compact('jenisLayanans'));
    }

    public function create()
    {
        return view('superadmin.jenis_layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|in:kiloan,satuan',
        ]);

        JenisLayanan::create($request->all());

        return redirect()->route('superadmin.jenis-layanan.index')->with('success', 'Jenis layanan berhasil ditambahkan.');
    }

    public function edit(JenisLayanan $jenisLayanan)
    {
        return view('superadmin.jenis_layanan.edit', compact('jenisLayanan'));
    }

    public function update(Request $request, JenisLayanan $jenisLayanan)
    {
        $request->validate([
            'nama_layanan' => 'required|in:kiloan,satuan',
        ]);

        $jenisLayanan->update($request->all());

        return redirect()->route('superadmin.jenis-layanan.index')->with('success', 'Jenis layanan berhasil diperbarui.');
    }

    public function destroy(JenisLayanan $jenisLayanan)
    {
        $jenisLayanan->delete();
        return redirect()->route('superadmin.jenis-layanan.index')->with('success', 'Jenis layanan berhasil dihapus.');
    }
}