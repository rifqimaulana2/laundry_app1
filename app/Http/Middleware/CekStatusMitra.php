<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mitra;

class CekStatusMitra
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Hanya berlaku untuk user dengan role 'mitra'
        if ($user && $user->role === 'mitra') {
            $mitra = Mitra::where('user_id', $user->id)->first();

            if (!$mitra || $mitra->status_approve !== 'disetujui') {
                Auth::logout();

                return redirect()->route('login')->withErrors([
                    'email' => 'Akun mitra Anda belum disetujui oleh Superadmin.',
                ]);
            }
        }

        return $next($request);
    }
}
