<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananMitraSatuanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('layanan_mitra_satuan')->insert([
            ['id' => 1,  'layanan_satuan_id' => 1, 'mitra_id' => 2, 'harga_per_item' => 15000],
            ['id' => 2,  'layanan_satuan_id' => 2, 'mitra_id' => 2, 'harga_per_item' => 12000],
            ['id' => 3,  'layanan_satuan_id' => 4, 'mitra_id' => 2, 'harga_per_item' => 13000],
            ['id' => 4,  'layanan_satuan_id' => 1, 'mitra_id' => 3, 'harga_per_item' => 14000],
            ['id' => 5,  'layanan_satuan_id' => 3, 'mitra_id' => 3, 'harga_per_item' => 10000],
            ['id' => 6,  'layanan_satuan_id' => 5, 'mitra_id' => 3, 'harga_per_item' => 16000],
            ['id' => 7,  'layanan_satuan_id' => 2, 'mitra_id' => 4, 'harga_per_item' => 12500],
            ['id' => 8,  'layanan_satuan_id' => 4, 'mitra_id' => 4, 'harga_per_item' => 13500],
            ['id' => 9,  'layanan_satuan_id' => 5, 'mitra_id' => 4, 'harga_per_item' => 15500],
            ['id' => 10, 'layanan_satuan_id' => 1, 'mitra_id' => 5, 'harga_per_item' => 14500],
            ['id' => 11, 'layanan_satuan_id' => 2, 'mitra_id' => 5, 'harga_per_item' => 13000],
            ['id' => 12, 'layanan_satuan_id' => 3, 'mitra_id' => 5, 'harga_per_item' => 11000],
        ]);
    }
}
