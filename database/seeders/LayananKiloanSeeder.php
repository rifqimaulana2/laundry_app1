<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananKiloanSeeder extends Seeder
{
    public function run()
{
    DB::table('layanan_kiloan')->insert([
        ['jenis_layanan_id' => 1, 'nama_paket' => 'Reguler', 'created_at' => now(), 'updated_at' => now()],
        ['jenis_layanan_id' => 1, 'nama_paket' => 'Ekspres', 'created_at' => now(), 'updated_at' => now()],
    ]);
}
}
