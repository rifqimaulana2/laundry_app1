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
     * Menampilkan form login
     */
    public function create(): View
    {
        return view('auth.login'); // ✅ Pastikan view login ada
    }

    /**
     * Proses autentikasi login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        // 🔒 Blokir login mitra jika belum disetujui (pakai status_approve dari tabel users)
        if ($user->role === 'mitra' && $user->status_approve !== 1) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun mitra Anda belum disetujui oleh admin.',
            ]);
        }

        // 🔀 Redirect sesuai role
        return match ($user->role) {
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'mitra'      => redirect()->route('mitra.dashboard'),
            'pelanggan'  => redirect()->route('pelanggan.dashboard'),
            default      => redirect('/'),
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
