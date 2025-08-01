<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananMitraSatuanSeeder extends Seeder
{
    public function run()
    {
        DB::table('layanan_mitra_satuan')->insert([
            ['layanan_satuan_id' => 1, 'mitra_id' => 1, 'harga_per_item' => 15000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 2, 'mitra_id' => 1, 'harga_per_item' => 23000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 3, 'mitra_id' => 1, 'harga_per_item' => 24000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 4, 'mitra_id' => 1, 'harga_per_item' => 54000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 5, 'mitra_id' => 1, 'harga_per_item' => 31000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 6, 'mitra_id' => 1, 'harga_per_item' => 36000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 1, 'mitra_id' => 2, 'harga_per_item' => 17000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 2, 'mitra_id' => 2, 'harga_per_item' => 22000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 3, 'mitra_id' => 2, 'harga_per_item' => 26000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 4, 'mitra_id' => 2, 'harga_per_item' => 52000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 5, 'mitra_id' => 2, 'harga_per_item' => 29000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 6, 'mitra_id' => 2, 'harga_per_item' => 37000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 1, 'mitra_id' => 3, 'harga_per_item' => 16000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 2, 'mitra_id' => 3, 'harga_per_item' => 21000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 3, 'mitra_id' => 3, 'harga_per_item' => 27000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 4, 'mitra_id' => 3, 'harga_per_item' => 31000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 5, 'mitra_id' => 3, 'harga_per_item' => 32000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 6, 'mitra_id' => 3, 'harga_per_item' => 36000, 'durasi_hari' => 3],
            ['layanan_satuan_id' => 1, 'mitra_id' => 4, 'harga_per_item' => 17000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 2, 'mitra_id' => 4, 'harga_per_item' => 22000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 3, 'mitra_id' => 4, 'harga_per_item' => 25000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 4, 'mitra_id' => 4, 'harga_per_item' => 32000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 5, 'mitra_id' => 4, 'harga_per_item' => 55000, 'durasi_hari' => 2],
            ['layanan_satuan_id' => 6, 'mitra_id' => 4, 'harga_per_item' => 36000, 'durasi_hari' => 2],
        ]);
    }
}
