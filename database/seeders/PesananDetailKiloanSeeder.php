<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananDetailKiloanSeeder extends Seeder
{
    public function run()
    {
        DB::table('pesanan_detail_kiloan')->insert([
            [
                'pesanan_id' => 1,
                'layanan_mitra_kiloan_id' => 2,
                'berat_sementara' => 4.0,
                'berat_final' => null,
                'harga_per_kg' => 12000,
                'subtotal' => null,
            ],
            [
                'pesanan_id' => 2,
                'layanan_mitra_kiloan_id' => 1,
                'berat_sementara' => 3.0,
                'berat_final' => null,
                'harga_per_kg' => 7000,
                'subtotal' => null,
            ],
            [
                'pesanan_id' => 3,
                'layanan_mitra_kiloan_id' => 3,
                'berat_sementara' => 4.5,
                'berat_final' => null,
                'harga_per_kg' => 7500,
                'subtotal' => null,
            ],
            [
                'pesanan_id' => 5,
                'layanan_mitra_kiloan_id' => 5,
                'berat_sementara' => 5.0,
                'berat_final' => 4.8,
                'harga_per_kg' => 6500,
                'subtotal' => 31200,
            ],
            [
                'pesanan_id' => 7,
                'layanan_mitra_kiloan_id' => 1,
                'berat_sementara' => null,
                'berat_final' => 3.8,
                'harga_per_kg' => 7000,
                'subtotal' => 26600,
            ],
            [
                'pesanan_id' => 8,
                'layanan_mitra_kiloan_id' => 2,
                'berat_sementara' => null,
                'berat_final' => 4.2,
                'harga_per_kg' => 12000,
                'subtotal' => 50400,
            ],
            [
                'pesanan_id' => 9,
                'layanan_mitra_kiloan_id' => 1,
                'berat_sementara' => 3.0,
                'berat_final' => 3.0,
                'harga_per_kg' => 12000,
                'subtotal' => 36000,
            ],
            [
                'pesanan_id' => 11,
                'layanan_mitra_kiloan_id' => 1,
                'berat_sementara' => 4.0,
                'berat_final' => 4.0,
                'harga_per_kg' => 7000,
                'subtotal' => 28000,
            ],
        ]);
    }
}
