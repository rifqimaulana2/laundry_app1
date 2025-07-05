<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilMitraController extends Controller
{
    public function index()
    {
        $mitra = Auth::user()->mitra;
        return view('mitra.profil.index', compact('mitra'));
    }

    public function edit()
    {
        $mitra = Auth::user()->mitra;
        return view('mitra.profil.edit', compact('mitra'));
    }

    public function update(Request $request)
    {
        $mitra = Auth::user()->mitra;

        $request->validate([
            'nama' => 'required|string|max:100',
            'nama_toko' => 'required|string|max:100',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'kecamatan' => 'nullable|string|max:100',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
        ]);

        $mitra->update($request->only([
            'nama', 'nama_toko', 'alamat', 'no_telepon',
            'kecamatan', 'longitude', 'latitude'
        ]));

        return redirect()->route('mitra.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
