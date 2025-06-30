<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            JenisLayananSeeder::class,
            LayananKiloanSeeder::class,
            LayananSatuanSeeder::class,
            StatusSeeder::class,
            MitraSeeder::class,
            PelangganSeeder::class,
            LayananMitraSeeder::class,
            JamOperasionalSeeder::class,


        ]);
    }
}
