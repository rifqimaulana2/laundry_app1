<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        'name'        => 'required|string|max:255',
        'email'       => 'required|string|email|max:255|unique:users',
        'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        'role'        => 'required|in:mitra,pelanggan',
        'nama_usaha'  => 'required_if:role,mitra',
        'no_telepon'  => 'required_if:role,mitra',
        'kecamatan'   => 'required_if:role,mitra',
    ]);

    $user = User::create([
        'name'         => $request->name,
        'email'        => strtolower($request->email),
        'password'     => Hash::make($request->password),
        'role'         => $request->role,
        'nama_usaha'   => $request->nama_usaha,
        'no_telepon'   => $request->no_telepon,
        'kecamatan'    => $request->kecamatan,
    ]);

    $user->assignRole($request->role);

    if ($request->role === 'mitra') {
        return redirect()->route('login')->with('status', 'Pendaftaran mitra berhasil. Tunggu persetujuan admin.');
    }

    auth()->login($user);
    return redirect()->route('pelanggan.lengkapi-profil');
}
}