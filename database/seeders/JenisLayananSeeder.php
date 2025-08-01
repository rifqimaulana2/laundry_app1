<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisLayananSeeder extends Seeder
{
    public function run()
{
    DB::table('jenis_layanan')->insert([
        ['nama_layanan' => 'Kiloan', 'created_at' => now(), 'updated_at' => now()],
        ['nama_layanan' => 'Satuan', 'created_at' => now(), 'updated_at' => now()],
    ]);
    }
}
