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
        \Config::set('midtrans.serverKey', env('MIDTRANS_SERVER_KEY'));
        \Config::set('midtrans.isProduction', false); // ubah ke true untuk production
        \Config::set('midtrans.sanitized', true);
        \Config::set('midtrans.enable3ds', true);

        // ✅ Manual Route Model Binding (supaya {tagihan} otomatis di-resolve)
        Route::bind('tagihan', function ($value) {
            return Tagihan::findOrFail($value);
        });
    }
}
