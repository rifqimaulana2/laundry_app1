<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Tagihan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Konfigurasi Midtrans
         \Midtrans\Config::$serverKey    = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = (bool) config('midtrans.is_production');
    \Midtrans\Config::$isSanitized  = (bool) config('midtrans.is_sanitized', true);
    \Midtrans\Config::$is3ds        = (bool) config('midtrans.is_3ds', true);

        // ✅ Manual Route Model Binding (supaya {tagihan} otomatis di-resolve)
        Route::bind('tagihan', function ($value) {
            return Tagihan::findOrFail($value);
        });
    }
}
