<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config as MidtransConfig;

class MidtransServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $cfg = config('services.midtrans');
        if (!$cfg) return;

        MidtransConfig::$serverKey   = $cfg['server_key'] ?? null;
        MidtransConfig::$isProduction= (bool)($cfg['is_production'] ?? false);
        MidtransConfig::$isSanitized = (bool)($cfg['is_sanitized'] ?? true);
        MidtransConfig::$is3ds       = (bool)($cfg['is_3ds'] ?? true);
    }
}
