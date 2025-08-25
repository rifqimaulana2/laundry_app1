<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureMitraApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role === 'mitra') {
            $mitra = $user->mitra;
            $status = strtolower(trim($mitra->status_approve ?? ''));

            if ($status !== 'disetujui') {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => $status === 'pending'
                        ? 'Akun mitra Anda masih dalam proses verifikasi.'
                        : 'Akun mitra Anda ditolak/dinonaktifkan.',
                ]);
            }
        }

        return $next($request);
    }
}
