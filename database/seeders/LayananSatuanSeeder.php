<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSatuanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('layanan_satuan')->insert([
            ['nama_layanan' => 'Sepatu'],
            ['nama_layanan' => 'Jaket'],
            ['nama_layanan' => 'Boneka Kecil'],
            ['nama_layanan' => 'Tas Sekolah'],
            ['nama_layanan' => 'Sprei'],
        ]);
    }
}
