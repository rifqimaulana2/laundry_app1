<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PelangganProfile;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'password'        => ['required', 'confirmed', Rules\Password::defaults()],
            'role'            => 'required|in:mitra,pelanggan',

            // Pelanggan
            'alamat'          => 'required_if:role,pelanggan|string|max:255',
            'no_telepon'      => 'required_if:role,pelanggan|string|max:20',

            // Mitra
            'nama_usaha'      => 'required_if:role,mitra|string|max:255',
            'no_telepon'      => 'required_if:role,mitra|string|max:20',
            'kecamatan'       => 'required_if:role,mitra|string|max:255',
            'alamat_lengkap'  => 'required_if:role,mitra|string|max:255',
            'longitude'       => 'required_if:role,mitra|string|max:255',
            'latitude'        => 'required_if:role,mitra|string|max:255',
        ]);

        // Simpan ke tabel users
        $user = User::create([
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'created_at' => now(),
        ]);

        $user->assignRole($request->role);

        if ($request->role === 'pelanggan') {
            PelangganProfile::create([
                'user_id'     => $user->id,
                'alamat'      => $request->alamat,
                'no_telepon'  => $request->no_telepon,
                'foto_profil' => null,
                'updated_at'  => now(),
            ]);

            auth()->login($user);
            return redirect()->route('pelanggan.lengkapi-profil');
        }

        // Jika role = mitra → simpan ke tabel mitras
        Mitra::create([
            'user_id'        => $user->id,
            'nama_toko'      => $request->nama_usaha,
            'kecamatan'      => $request->kecamatan,
            'alamat_lengkap' => $request->alamat_lengkap,
            'longitude'      => $request->longitude,
            'latitude'       => $request->latitude,
            'no_telepon'     => $request->no_telepon,
            'status_approve' => 'pending',
            'foto_toko'      => null,
            'foto_profile'   => null,
            'updated_at'     => now(),
        ]);

        return redirect()->route('login')->with('status', 'Pendaftaran mitra berhasil. Tunggu persetujuan admin.');
    }
}