<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan form registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses penyimpanan registrasi user.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi umum
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:pelanggan,mitra,superadmin'],
        ]);

        // Jika mitra, validasi tambahan
        if ($request->role === 'mitra') {
            $request->validate([
                'no_telepon' => ['required', 'string', 'max:20'],
                'alamat' => ['required', 'string'],
                'kecamatan' => ['required', 'string'],
                'foto_profil' => ['nullable', 'image', 'max:2048'],
            ]);
        }

        // Set persetujuan berdasarkan role
        $isApproved = $request->role !== 'mitra';

        // Handle upload foto profil
        $fotoProfil = null;
        if ($request->hasFile('foto_profil')) {
            $fotoProfil = $request->file('foto_profil')->store('mitra/foto', 'public');
        }

        // Buat user
        $user = User::create([
            'name'         => $request->name,
            'email'        => strtolower($request->email),
            'password'     => Hash::make($request->password),
            'no_telepon'   => $request->no_telepon ?? null,
            'alamat'       => $request->alamat ?? null,
            'kecamatan'    => $request->kecamatan ?? null,
            'foto_profil'  => $fotoProfil,
            'is_approved'  => $isApproved,
        ]);

        // Assign role
        $user->assignRole($request->role);

        // Event registrasi
        event(new Registered($user));

        // Login langsung jika sudah disetujui
        if ($user->is_approved) {
            Auth::login($user);

            return match (true) {
                $user->hasRole('superadmin') => redirect()->route('superadmin.dashboard'),
                $user->hasRole('mitra')      => redirect()->route('mitra.dashboard'),
                $user->hasRole('pelanggan')  => redirect()->route('pelanggan.data-diri'),
                default                      => redirect('/'),
            };
        }

        // Jika mitra, tampilkan notifikasi menunggu persetujuan
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Akun Anda akan ditinjau oleh admin sebelum bisa login.');
    }
}
