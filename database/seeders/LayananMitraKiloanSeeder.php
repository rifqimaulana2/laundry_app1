<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananMitraKiloanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('layanan_mitra_kiloan')->insert([
            ['layanan_kiloan_id' => 1, 'mitra_id' => 2, 'harga_per_kg' => 7000],
            ['layanan_kiloan_id' => 2, 'mitra_id' => 2, 'harga_per_kg' => 12000],
            ['layanan_kiloan_id' => 1, 'mitra_id' => 3, 'harga_per_kg' => 6500],
            ['layanan_kiloan_id' => 2, 'mitra_id' => 3, 'harga_per_kg' => 11000],
            ['layanan_kiloan_id' => 1, 'mitra_id' => 4, 'harga_per_kg' => 7500],
            ['layanan_kiloan_id' => 2, 'mitra_id' => 4, 'harga_per_kg' => 13000],
            ['layanan_kiloan_id' => 1, 'mitra_id' => 5, 'harga_per_kg' => 6800],
            ['layanan_kiloan_id' => 2, 'mitra_id' => 5, 'harga_per_kg' => 12500],
        ]);
    }
}
