<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananKiloanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('layanan_kiloan')->insert([
            ['id' => 1, 'nama_paket' => 'Reguler', 'durasi_hari' => 3],
            ['id' => 2, 'nama_paket' => 'Express', 'durasi_hari' => 1],
        ]);
    }
}
