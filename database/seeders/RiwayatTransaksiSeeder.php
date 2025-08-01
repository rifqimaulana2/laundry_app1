<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RiwayatTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('riwayat_transaksi')->insert([
            ['pesanan_id' => 1, 'user_id' => 6, 'nominal' => 20000, 'jenis_transaksi' => 'dp', 'metode_bayar' => 'transfer', 'waktu' => '2025-07-20 09:30:00'],
            ['pesanan_id' => 2, 'user_id' => 7, 'nominal' => 15000, 'jenis_transaksi' => 'dp', 'metode_bayar' => 'transfer', 'waktu' => '2025-07-21 10:30:00'],
            ['pesanan_id' => 3, 'user_id' => 8, 'nominal' => 17000, 'jenis_transaksi' => 'dp', 'metode_bayar' => 'transfer', 'waktu' => '2025-07-21 05:00:00'],
            ['pesanan_id' => 4, 'user_id' => 9, 'nominal' => 39000, 'jenis_transaksi' => 'pembayaran', 'metode_bayar' => 'transfer', 'waktu' => '2025-07-21 05:00:00'],
            ['pesanan_id' => 5, 'user_id' => 10, 'nominal' => 30000, 'jenis_transaksi' => 'dp', 'metode_bayar' => 'transfer', 'waktu' => '2025-07-21 05:30:00'],
            ['pesanan_id' => 5, 'user_id' => 10, 'nominal' => 32200, 'jenis_transaksi' => 'pelunasan', 'metode_bayar' => 'transfer', 'waktu' => '2025-07-24 14:00:00'],
            ['pesanan_id' => 6, 'user_id' => null, 'nominal' => 54000, 'jenis_transaksi' => 'pembayaran', 'metode_bayar' => 'cash', 'waktu' => '2025-07-21 10:00:00'],
            ['pesanan_id' => 7, 'user_id' => null, 'nominal' => 30000, 'jenis_transaksi' => 'dp', 'metode_bayar' => 'transfer', 'waktu' => '2025-07-21 05:45:00'],
            ['pesanan_id' => 7, 'user_id' => null, 'nominal' => 32600, 'jenis_transaksi' => 'pelunasan', 'metode_bayar' => 'cash', 'waktu' => '2025-07-24 15:00:00'],
            ['pesanan_id' => 8, 'user_id' => null, 'nominal' => 25000, 'jenis_transaksi' => 'dp', 'metode_bayar' => 'transfer', 'waktu' => '2025-07-21 06:00:00'],
            ['pesanan_id' => 9, 'user_id' => 17, 'nominal' => 36000, 'jenis_transaksi' => 'pembayaran', 'metode_bayar' => 'cash', 'waktu' => '2025-07-22 17:27:00'],
            ['pesanan_id' => 10, 'user_id' => 18, 'nominal' => 30000, 'jenis_transaksi' => 'dp', 'metode_bayar' => 'transfer', 'waktu' => '2025-07-22 17:39:00'],
            ['pesanan_id' => 11, 'user_id' => 19, 'nominal' => 87000, 'jenis_transaksi' => 'pembayaran', 'metode_bayar' => 'cash', 'waktu' => '2025-07-22 17:53:00'],
        ]);
    }
}
