<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('riwayat_transaksi')->insert([
            [
                'id' => 1,
                'pesanan_id' => 1,
                'keterangan' => 'DP',
                'jumlah' => 10000,
            ],
            [
                'id' => 2,
                'pesanan_id' => 2,
                'keterangan' => 'DP',
                'jumlah' => 10000,
            ],
            [
                'id' => 3,
                'pesanan_id' => 3,
                'keterangan' => 'DP',
                'jumlah' => 10000,
            ],
            [
                'id' => 4,
                'pesanan_id' => 4,
                'keterangan' => 'DP',
                'jumlah' => 10000,
            ],
            [
                'id' => 5,
                'pesanan_id' => 5,
                'keterangan' => 'DP',
                'jumlah' => 10000,
            ],
            [
                'id' => 6,
                'pesanan_id' => 6,
                'keterangan' => 'DP',
                'jumlah' => 10000,
            ],
            [
                'id' => 7,
                'pesanan_id' => 7,
                'keterangan' => 'DP',
                'jumlah' => 10000,
            ],
            [
                'id' => 8,
                'pesanan_id' => 8,
                'keterangan' => 'DP',
                'jumlah' => 10000,
            ],
        ]);
    }
}
