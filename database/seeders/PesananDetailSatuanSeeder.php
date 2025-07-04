<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananDetailSatuanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pesanan_detail_satuan')->insert([
            [
                'id' => 1,
                'pesanan_id' => 2,
                'layanan_mitra_satuan_id' => 5,
                'jumlah_item' => 2,
                'harga_per_item' => 10000,
                'subtotal' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'pesanan_id' => 4,
                'layanan_mitra_satuan_id' => 2,
                'jumlah_item' => 1,
                'harga_per_item' => 12000,
                'subtotal' => 12000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'pesanan_id' => 5,
                'layanan_mitra_satuan_id' => 11,
                'jumlah_item' => 1,
                'harga_per_item' => 13000,
                'subtotal' => 13000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'pesanan_id' => 6,
                'layanan_mitra_satuan_id' => 2,
                'jumlah_item' => 1,
                'harga_per_item' => 12000,
                'subtotal' => 12000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'pesanan_id' => 7,
                'layanan_mitra_satuan_id' => 4,
                'jumlah_item' => 1,
                'harga_per_item' => 14000,
                'subtotal' => 14000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'pesanan_id' => 8,
                'layanan_mitra_satuan_id' => 6,
                'jumlah_item' => 1,
                'harga_per_item' => 16000,
                'subtotal' => 16000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
