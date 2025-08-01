<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananDetailSatuanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pesanan_detail_satuan')->insert([
            ['pesanan_id' => 2, 'layanan_mitra_satuan_id' => 2, 'jumlah_item' => 1, 'harga_per_item' => 23000, 'subtotal' => 23000],
            ['pesanan_id' => 4, 'layanan_mitra_satuan_id' => 1, 'jumlah_item' => 1, 'harga_per_item' => 15000, 'subtotal' => 15000],
            ['pesanan_id' => 4, 'layanan_mitra_satuan_id' => 3, 'jumlah_item' => 1, 'harga_per_item' => 24000, 'subtotal' => 24000],
            ['pesanan_id' => 5, 'layanan_mitra_satuan_id' => 5, 'jumlah_item' => 1, 'harga_per_item' => 31000, 'subtotal' => 31000],
            ['pesanan_id' => 6, 'layanan_mitra_satuan_id' => 2, 'jumlah_item' => 1, 'harga_per_item' => 23000, 'subtotal' => 23000],
            ['pesanan_id' => 6, 'layanan_mitra_satuan_id' => 5, 'jumlah_item' => 1, 'harga_per_item' => 31000, 'subtotal' => 31000],
            ['pesanan_id' => 7, 'layanan_mitra_satuan_id' => 6, 'jumlah_item' => 1, 'harga_per_item' => 36000, 'subtotal' => 36000],
            ['pesanan_id' => 10, 'layanan_mitra_satuan_id' => 2, 'jumlah_item' => 1, 'harga_per_item' => 15000, 'subtotal' => 15000],
            ['pesanan_id' => 10, 'layanan_mitra_satuan_id' => 3, 'jumlah_item' => 1, 'harga_per_item' => 24000, 'subtotal' => 24000],
            ['pesanan_id' => 10, 'layanan_mitra_satuan_id' => 4, 'jumlah_item' => 1, 'harga_per_item' => 54000, 'subtotal' => 54000],
            ['pesanan_id' => 11, 'layanan_mitra_satuan_id' => 2, 'jumlah_item' => 1, 'harga_per_item' => 23000, 'subtotal' => 23000],
            ['pesanan_id' => 11, 'layanan_mitra_satuan_id' => 6, 'jumlah_item' => 1, 'harga_per_item' => 36000, 'subtotal' => 36000],
        ]);
    }
}
