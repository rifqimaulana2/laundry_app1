<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSatuanSeeder extends Seeder
{
    public function run()
    {
        DB::table('layanan_satuan')->insert([
            ['jenis_layanan_id' => 2, 'nama_layanan' => 'Sepatu'],
            ['jenis_layanan_id' => 2, 'nama_layanan' => 'Boneka'],
            ['jenis_layanan_id' => 2, 'nama_layanan' => 'Sweater'],
            ['jenis_layanan_id' => 2, 'nama_layanan' => 'Bed Cover'],
            ['jenis_layanan_id' => 2, 'nama_layanan' => 'Jaket'],
            ['jenis_layanan_id' => 2, 'nama_layanan' => 'Tas'],
        ]);
    }
}
