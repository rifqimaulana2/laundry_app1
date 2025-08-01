<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LayananMitraKiloanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('layanan_mitra_kiloan')->insert([
        ['layanan_kiloan_id' => 1, 'mitra_id' => 1, 'harga_per_kg' => 7000, 'durasi_hari' => 3, 'created_at' => now(), 'updated_at' => now()],
        ['layanan_kiloan_id' => 2, 'mitra_id' => 1, 'harga_per_kg' => 12000, 'durasi_hari' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['layanan_kiloan_id' => 1, 'mitra_id' => 2, 'harga_per_kg' => 7500, 'durasi_hari' => 2, 'created_at' => now(), 'updated_at' => now()],
        ['layanan_kiloan_id' => 2, 'mitra_id' => 2, 'harga_per_kg' => 13000, 'durasi_hari' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['layanan_kiloan_id' => 1, 'mitra_id' => 3, 'harga_per_kg' => 6500, 'durasi_hari' => 3, 'created_at' => now(), 'updated_at' => now()],
        ['layanan_kiloan_id' => 2, 'mitra_id' => 3, 'harga_per_kg' => 11000, 'durasi_hari' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['layanan_kiloan_id' => 1, 'mitra_id' => 4, 'harga_per_kg' => 7500, 'durasi_hari' => 2, 'created_at' => now(), 'updated_at' => now()],
        ['layanan_kiloan_id' => 2, 'mitra_id' => 4, 'harga_per_kg' => 13000, 'durasi_hari' => 1, 'created_at' => now(), 'updated_at' => now()],
    ]);
}
}
