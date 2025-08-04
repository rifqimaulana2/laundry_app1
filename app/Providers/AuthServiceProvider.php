<?php

namespace App\Providers;

use App\Models\Pesanan;
use App\Models\JamOperasional;
use App\Models\LayananMitraKiloan;
use App\Models\LayananMitraSatuan;
use App\Policies\PesananPolicy;
use App\Policies\JamOperasionalPolicy;
use App\Policies\LayananMitraKiloanPolicy;
use App\Policies\LayananMitraSatuanPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Pesanan::class => PesananPolicy::class,
        JamOperasional::class => JamOperasionalPolicy::class,
        LayananMitraKiloan::class => LayananMitraKiloanPolicy::class,
        LayananMitraSatuan::class => LayananMitraSatuanPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}