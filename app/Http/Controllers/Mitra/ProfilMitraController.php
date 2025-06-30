<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Mitra;

class ProfilMitraController extends Controller
{
    public function index()
{
    $mitra = \App\Models\Mitra::where('user_id', auth()->id())->first();

    // Redirect jika belum mengisi profil
    if (!$mitra) {
        return redirect()->route('mitra.profil.edit')
            ->with('status', 'Silakan lengkapi profil mitra terlebih dahulu.');
    }

    return view('mitra.profil.index', [
        'profil' => $mitra
    ]);
}

    public function edit()
    {
        $mitra = Auth::user()->mitra;
        return view('mitra.profil.edit', compact('mitra'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'nama_toko'   => 'required|string|max:255',
            'alamat'      => 'required|string|max:500',
            'no_telepon'  => 'required|string|max:20',
            'kecamatan'   => 'required|string|max:100',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ]);

        $mitra = Auth::user()->mitra;

        $mitra->update([
            'nama'                 => $request->nama,
            'nama_toko'           => $request->nama_toko,
            'alamat'              => $request->alamat,
            'no_telepon'          => $request->no_telepon,
            'kecamatan'           => $request->kecamatan,
            'latitude'            => $request->latitude,
            'longitude'           => $request->longitude,
        ]);

        return redirect()->route('mitra.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
