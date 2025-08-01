<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function edit()
    {
        $mitra = auth()->user()->mitra;
        return view('mitra.profil.edit', compact('mitra'));
    }

    public function update(Request $request)
    {
        $mitra = auth()->user()->mitra;

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'longitude' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:255',
            'foto_toko' => 'nullable|image|max:2048',
            'foto_profile' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto_toko')) {
            $data['foto_toko'] = $request->file('foto_toko')->store('toko', 'public');
        }
        if ($request->hasFile('foto_profile')) {
            $data['foto_profile'] = $request->file('foto_profile')->store('profile', 'public');
        }

        $mitra->update($data);

        return redirect()->route('mitra.profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}