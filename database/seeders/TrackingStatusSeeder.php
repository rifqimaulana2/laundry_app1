<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackingStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tracking_status')->insert([
            [
                'id' => 1,
                'pesanan_id' => 1,
                'user_id' => 6,
                'mitra_id' => 5,
                'status_master_id' => 1,
                'waktu' => '2025-07-01 09:00:00',
                'aktivitas' => 'Pesanan berhasil dibuat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'pesanan_id' => 2,
                'user_id' => 7,
                'mitra_id' => 4, // ← sebelumnya 6
                'status_master_id' => 2,
                'waktu' => '2025-07-01 10:45:00',
                'aktivitas' => 'Kurir sedang menjemput pakaian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'pesanan_id' => 3,
                'user_id' => 8,
                'mitra_id' => 3, // ← sebelumnya 7
                'status_master_id' => 3,
                'waktu' => '2025-07-01 12:00:00',
                'aktivitas' => 'Pakaian sedang dicuci',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'pesanan_id' => 4,
                'user_id' => 9,
                'mitra_id' => 5,
                'status_master_id' => 4,
                'waktu' => '2025-07-01 17:30:00',
                'aktivitas' => 'Pakaian sudah selesai dicuci',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'pesanan_id' => 5,
                'user_id' => 10,
                'mitra_id' => 2, // ← sebelumnya 8
                'status_master_id' => 5,
                'waktu' => '2025-06-30 10:00:00',
                'aktivitas' => 'Kurir sedang mengantar paket',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'pesanan_id' => 6,
                'user_id' => null,
                'mitra_id' => 5,
                'status_master_id' => 3,
                'waktu' => '2025-07-01 09:30:00',
                'aktivitas' => 'Jaket dalam proses pencucian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'pesanan_id' => 7,
                'user_id' => null,
                'mitra_id' => 4, // ← sebelumnya 6
                'status_master_id' => 3,
                'waktu' => '2025-06-30 17:00:00',
                'aktivitas' => 'Barang dalam proses pencucian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'pesanan_id' => 8,
                'user_id' => null,
                'mitra_id' => 3, // ← sebelumnya 6
                'status_master_id' => 4,
                'waktu' => '2025-06-29 13:00:00',
                'aktivitas' => 'Silakan ambil ke toko',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
