<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananDetailKiloanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pesanan_detail_kiloan')->insert([
            [
                'id' => 1,
                'pesanan_id' => 1,
                'layanan_mitra_kiloan_id' => 1, // Reguler - mitra 2
                'berat_sementara' => 6,
                'berat_real' => 6,
                'harga_per_kg' => 7000,
                'subtotal' => 42000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'pesanan_id' => 2,
                'layanan_mitra_kiloan_id' => 4, // Express - mitra 3
                'berat_sementara' => 2,
                'berat_real' => 2,
                'harga_per_kg' => 11000,
                'subtotal' => 22000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'pesanan_id' => 3,
                'layanan_mitra_kiloan_id' => 5, // Reguler - mitra 4
                'berat_sementara' => 5,
                'berat_real' => 5,
                'harga_per_kg' => 7500,
                'subtotal' => 37500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'pesanan_id' => 7,
                'layanan_mitra_kiloan_id' => 3, // Reguler - mitra 3
                'berat_sementara' => 3,
                'berat_real' => 3,
                'harga_per_kg' => 6500,
                'subtotal' => 19500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
