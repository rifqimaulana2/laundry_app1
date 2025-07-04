<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisLayananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_layanan')->insert([
            ['id' => 1, 'nama_layanan' => 'Kiloan'],
            ['id' => 2, 'nama_layanan' => 'Satuan'],
        ]);
    }
}
