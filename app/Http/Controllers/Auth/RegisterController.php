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
        // Validasi berdasarkan role
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'password'        => ['required', 'confirmed', Rules\Password::defaults()],
            'role'            => 'required|in:mitra,pelanggan',

            // Umum (pelanggan & mitra)
            'no_telepon'      => 'required_if:role,pelanggan,mitra|string|max:20',

            // Pelanggan
            'alamat'          => 'required_if:role,pelanggan|string|max:255',

            // Mitra
            'nama_usaha'      => 'required_if:role,mitra|string|max:255',
            'kecamatan'       => 'required_if:role,mitra|string|max:255',
            'alamat_lengkap'  => 'required_if:role,mitra|string|max:255',
            'foto_toko'       => 'required_if:role,mitra|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan ke tabel users
        $user = User::create([
            'name'       => $request->name,
            'email'      => strtolower($request->email),
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'created_at' => now(),
        ]);

        // Assign Role
        $user->assignRole($request->role);

        // Jika role pelanggan
        if ($request->role === 'pelanggan') {
            PelangganProfile::create([
                'user_id'     => $user->id,
                'alamat'      => $request->alamat,
                'no_telepon'  => $request->no_telepon,
                'foto_profil' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            auth()->login($user);
return redirect()->route('pelanggan.dashboard'); 
// atau kalau mau langsung ke pesanan
// return redirect()->route('pelanggan.pesanan.index
        }

        // Jika role mitra, proses upload foto toko
        $fotoTokoPath = null;
        if ($request->hasFile('foto_toko')) {
            $fotoTokoPath = $request->file('foto_toko')->store('foto_toko', 'public');
        }

        Mitra::create([
            'user_id'        => $user->id,
            'nama_toko'      => $request->nama_usaha,
            'kecamatan'      => $request->kecamatan,
            'alamat_lengkap' => $request->alamat_lengkap,
            'no_telepon'     => $request->no_telepon,
            'longitude'      => null,
            'latitude'       => null,
            'status_approve' => 'pending',
            'foto_toko'      => $fotoTokoPath,
            'foto_profile'   => null,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect()->route('login')->with('status', 'Pendaftaran mitra berhasil. Tunggu persetujuan admin.');
    }
}
