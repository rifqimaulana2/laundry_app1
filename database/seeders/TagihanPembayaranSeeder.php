<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagihanPembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['id' => 1, 'pesanan_id' => 1, 'user_id' => 6, 'jumlah_tagihan' => 42000, 'sisa_tagihan' => 32000, 'status_bayar' => 'sebagian'],
            ['id' => 2, 'pesanan_id' => 2, 'user_id' => 7, 'jumlah_tagihan' => 42000, 'sisa_tagihan' => 32000, 'status_bayar' => 'sebagian'],
            ['id' => 3, 'pesanan_id' => 3, 'user_id' => 8, 'jumlah_tagihan' => 37500, 'sisa_tagihan' => 27500, 'status_bayar' => 'sebagian'],
            ['id' => 4, 'pesanan_id' => 4, 'user_id' => 9, 'jumlah_tagihan' => 18000, 'sisa_tagihan' => 8000, 'status_bayar' => 'sebagian'],
            ['id' => 5, 'pesanan_id' => 5, 'user_id' => 10, 'jumlah_tagihan' => 25000, 'sisa_tagihan' => 15000, 'status_bayar' => 'sebagian'],
            ['id' => 6, 'pesanan_id' => 6, 'user_id' => 11, 'jumlah_tagihan' => 15000, 'sisa_tagihan' => 5000, 'status_bayar' => 'sebagian'],
            ['id' => 7, 'pesanan_id' => 7, 'user_id' => 12, 'jumlah_tagihan' => 33500, 'sisa_tagihan' => 23500, 'status_bayar' => 'sebagian'],
            ['id' => 8, 'pesanan_id' => 8, 'user_id' => 13, 'jumlah_tagihan' => 16000, 'sisa_tagihan' => 6000, 'status_bayar' => 'sebagian'],
        ];

        DB::table('tagihan_pembayaran')->insert($data);
    }
}
