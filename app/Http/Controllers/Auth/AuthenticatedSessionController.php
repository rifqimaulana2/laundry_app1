<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Proses autentikasi
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // 🔒 Blokir login mitra jika belum diverifikasi / belum punya data di tabel mitras
        if ($user->role === 'mitra' && !$user->mitra) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun mitra Anda belum disetujui oleh admin.',
            ]);
        }

        // 🔀 Redirect berdasarkan role
        return match ($user->role) {
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'mitra'      => redirect()->route('mitra.dashboard'),
            'employee'   => redirect()->route('employee.dashboard'),
            'pelanggan'  => redirect()->route('pelanggan.dashboard'),
            default      => redirect()->route('home'),
        };
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
