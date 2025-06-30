<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $mitras = Mitra::with('langgananMitra')->latest()->get();
        return view('superadmin.mitra.index', compact('mitras'));
    }

    public function show($id)
    {
        $mitra = Mitra::with('langgananMitra')->findOrFail($id);
        return view('superadmin.mitra.show', compact('mitra'));
    }

    public function edit($id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('superadmin.mitra.edit', compact('mitra'));
    }

    public function update(Request $request, $id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->update($request->validate([
            'nama_toko' => 'required|string|max:100',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string',
            'kecamatan' => 'nullable|string',
        ]));

        return redirect()->route('superadmin.mitra.index')->with('success', 'Mitra diperbarui.');
    }
}
