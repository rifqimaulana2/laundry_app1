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
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // Proses autentikasi
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Cek apakah mitra belum disetujui
        if ($user->hasRole('mitra') && !$user->is_approved) {
            Auth::logout(); // Logout jika belum disetujui

            return redirect()->route('login')->withErrors([
                'email' => 'Akun mitra Anda belum disetujui oleh admin.',
            ]);
        }

        // Redirect sesuai role
        if ($user->hasRole('superadmin')) {
            return redirect()->route('superadmin.dashboard');
        }

        if ($user->hasRole('mitra')) {
            return redirect()->route('mitra.dashboard');
        }

        if ($user->hasRole('pelanggan')) {
            return redirect()->route('pelanggan.mitra');
        }

        return redirect('/');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
