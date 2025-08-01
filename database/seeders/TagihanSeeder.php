<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tagihans')->insert([
            [
                'pesanan_id' => 1,
                'total_tagihan' => null,
                'dp_dibayar' => 20000,
                'sisa_tagihan' => null,
                'metode_bayar' => 'transfer',
                'status_pembayaran' => 'belum lunas',
                'jatuh_tempo_pelunasan' => '2025-07-22',
                'waktu_bayar_dp' => '2025-07-20 09:30:00',
                'waktu_pelunasan' => null,
            ],
            [
                'pesanan_id' => 2,
                'total_tagihan' => null,
                'dp_dibayar' => 15000,
                'sisa_tagihan' => null,
                'metode_bayar' => 'transfer',
                'status_pembayaran' => 'belum lunas',
                'jatuh_tempo_pelunasan' => '2025-07-24',
                'waktu_bayar_dp' => '2025-07-21 10:30:00',
                'waktu_pelunasan' => null,
            ],
            [
                'pesanan_id' => 3,
                'total_tagihan' => null,
                'dp_dibayar' => 17000,
                'sisa_tagihan' => null,
                'metode_bayar' => 'transfer',
                'status_pembayaran' => 'belum lunas',
                'jatuh_tempo_pelunasan' => '2025-07-25',
                'waktu_bayar_dp' => '2025-07-21 05:00:00',
                'waktu_pelunasan' => null,
            ],
            [
                'pesanan_id' => 4,
                'total_tagihan' => 39000,
                'dp_dibayar' => 0,
                'sisa_tagihan' => 0,
                'metode_bayar' => 'transfer',
                'status_pembayaran' => 'lunas',
                'jatuh_tempo_pelunasan' => null,
                'waktu_bayar_dp' => null,
                'waktu_pelunasan' => '2025-07-21 05:00:00',
            ],
            [
                'pesanan_id' => 5,
                'total_tagihan' => 62200,
                'dp_dibayar' => 30000,
                'sisa_tagihan' => 32200,
                'metode_bayar' => 'transfer',
                'status_pembayaran' => 'lunas',
                'jatuh_tempo_pelunasan' => '2025-07-24',
                'waktu_bayar_dp' => '2025-07-21 05:30:00',
                'waktu_pelunasan' => '2025-07-24 14:00:00',
            ],
            [
                'pesanan_id' => 6,
                'total_tagihan' => 54000,
                'dp_dibayar' => 0,
                'sisa_tagihan' => 0,
                'metode_bayar' => 'cash',
                'status_pembayaran' => 'lunas',
                'jatuh_tempo_pelunasan' => null,
                'waktu_bayar_dp' => null,
                'waktu_pelunasan' => '2025-07-21 10:00:00',
            ],
            [
                'pesanan_id' => 7,
                'total_tagihan' => 62600,
                'dp_dibayar' => 30000,
                'sisa_tagihan' => 32600,
                'metode_bayar' => 'cash',
                'status_pembayaran' => 'belum lunas',
                'jatuh_tempo_pelunasan' => '2025-07-24',
                'waktu_bayar_dp' => '2025-07-21 05:45:00',
                'waktu_pelunasan' => null,
            ],
            [
                'pesanan_id' => 8,
                'total_tagihan' => 50400,
                'dp_dibayar' => 25000,
                'sisa_tagihan' => 25400,
                'metode_bayar' => 'transfer',
                'status_pembayaran' => 'belum lunas',
                'jatuh_tempo_pelunasan' => '2025-07-22',
                'waktu_bayar_dp' => '2025-07-21 06:00:00',
                'waktu_pelunasan' => null,
            ],
            [
                'pesanan_id' => 9,
                'total_tagihan' => 36000,
                'dp_dibayar' => 36000,
                'sisa_tagihan' => 0,
                'metode_bayar' => 'cash',
                'status_pembayaran' => 'lunas',
                'jatuh_tempo_pelunasan' => null,
                'waktu_bayar_dp' => null,
                'waktu_pelunasan' => '2025-07-22 17:27:00',
            ],
            [
                'pesanan_id' => 10,
                'total_tagihan' => 93000,
                'dp_dibayar' => 30000,
                'sisa_tagihan' => 63000,
                'metode_bayar' => 'transfer',
                'status_pembayaran' => 'dp_terbayar',
                'jatuh_tempo_pelunasan' => '2025-07-24',
                'waktu_bayar_dp' => '2025-07-22 17:39:00',
                'waktu_pelunasan' => null,
            ],
            [
                'pesanan_id' => 11,
                'total_tagihan' => 87000,
                'dp_dibayar' => 87000,
                'sisa_tagihan' => 0,
                'metode_bayar' => 'cash',
                'status_pembayaran' => 'lunas',
                'jatuh_tempo_pelunasan' => null,
                'waktu_bayar_dp' => null,
                'waktu_pelunasan' => '2025-07-22 17:53:00',
            ],
        ]);
    }
}
