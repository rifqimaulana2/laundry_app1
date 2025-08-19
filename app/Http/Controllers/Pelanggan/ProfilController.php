<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\PelangganProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman edit profil pelanggan.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $profile = PelangganProfile::where('user_id', Auth::id())->firstOrFail();
        return view('pelanggan.profil.edit', compact('profile'));
    }

    /**
     * Memperbarui data profil pelanggan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|max:2048', // Maksimal 2MB untuk foto
        ]);

        $profile = PelangganProfile::where('user_id', Auth::id())->firstOrFail();
        $profile->alamat = $request->alamat;
        $profile->no_telepon = $request->no_telepon;

        if ($request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')->store('profiles', 'public');
            $profile->foto_profil = $fotoPath;
        }

        $profile->save();

        return redirect()->route('pelanggan.profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}