<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotifikasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notifikasi')->insert([
            [
                'id' => 1,
                'pesanan_id' => 1,
                'user_id' => 6,
                'pesan' => 'Pesanan Anda telah berhasil dibuat',
                'status_baca' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'pesanan_id' => 2,
                'user_id' => 7,
                'pesan' => 'Kurir akan segera menjemput pesanan Anda',
                'status_baca' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'pesanan_id' => 3,
                'user_id' => 8,
                'pesan' => 'Pesanan Anda sedang diproses',
                'status_baca' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'pesanan_id' => 4,
                'user_id' => 9,
                'pesan' => 'Pesanan telah selesai dan siap diambil',
                'status_baca' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'pesanan_id' => 5,
                'user_id' => 10,
                'pesan' => 'Paket sedang dalam perjalanan',
                'status_baca' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
