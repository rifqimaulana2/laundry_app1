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
        // Proses autentikasi standar
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Helper untuk blokir + bersihkan sesi
        $block = function (string $message) use ($request): RedirectResponse {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => $message])
                ->onlyInput('email');
        };

        // 🔒 Validasi khusus role mitra
        if ($user->role === 'mitra') {
            // Pastikan relasi mitra ada
            if (!$user->mitra) {
                return $block('Akun mitra Anda belum diverifikasi oleh admin.');
            }

            // Ambil status_approve dari tabel mitras
            $status = strtolower(trim($user->mitra->status_approve));

            // Hanya disetujui yang boleh login
            if ($status !== 'disetujui') {
                $message = match ($status) {
                    'pending' => 'Akun mitra Anda masih dalam proses verifikasi.',
                    'ditolak' => 'Pendaftaran/izin mitra Anda ditolak atau dicabut. Silakan hubungi admin.',
                    default   => 'Akun mitra Anda tidak aktif.',
                };
                return $block($message);
            }
        }

        // 🔀 Redirect berdasarkan role
        return match ($user->role) {
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'mitra'      => redirect()->route('mitra.dashboard'),
            'employee'   => redirect()->route('mitra.pesanan.index'),
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
