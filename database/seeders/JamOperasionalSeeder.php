<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JamOperasionalSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Mitra ID 2
            ['mitra_id' => 2, 'hari_buka' => 'Senin',  'jam_buka' => '07:30', 'jam_tutup' => '21:00'],
            ['mitra_id' => 2, 'hari_buka' => 'Selasa', 'jam_buka' => '07:30', 'jam_tutup' => '21:00'],
            ['mitra_id' => 2, 'hari_buka' => 'Rabu',   'jam_buka' => '07:30', 'jam_tutup' => '21:00'],
            ['mitra_id' => 2, 'hari_buka' => 'Kamis',  'jam_buka' => '07:30', 'jam_tutup' => '21:00'],
            ['mitra_id' => 2, 'hari_buka' => 'Jumat',  'jam_buka' => '07:30', 'jam_tutup' => '21:00'],
            ['mitra_id' => 2, 'hari_buka' => 'Sabtu',  'jam_buka' => '08:00', 'jam_tutup' => '20:00'],

            // Mitra ID 3
            ['mitra_id' => 3, 'hari_buka' => 'Senin',  'jam_buka' => '08:00', 'jam_tutup' => '19:00'],
            ['mitra_id' => 3, 'hari_buka' => 'Selasa', 'jam_buka' => '08:00', 'jam_tutup' => '19:00'],
            ['mitra_id' => 3, 'hari_buka' => 'Rabu',   'jam_buka' => '08:00', 'jam_tutup' => '19:00'],
            ['mitra_id' => 3, 'hari_buka' => 'Kamis',  'jam_buka' => '08:00', 'jam_tutup' => '19:00'],
            ['mitra_id' => 3, 'hari_buka' => 'Jumat',  'jam_buka' => '08:00', 'jam_tutup' => '19:00'],

            // Mitra ID 4
            ['mitra_id' => 4, 'hari_buka' => 'Senin',  'jam_buka' => '09:00', 'jam_tutup' => '18:00'],
            ['mitra_id' => 4, 'hari_buka' => 'Selasa', 'jam_buka' => '09:00', 'jam_tutup' => '18:00'],
            ['mitra_id' => 4, 'hari_buka' => 'Rabu',   'jam_buka' => '09:00', 'jam_tutup' => '18:00'],
            ['mitra_id' => 4, 'hari_buka' => 'Kamis',  'jam_buka' => '09:00', 'jam_tutup' => '18:00'],
            ['mitra_id' => 4, 'hari_buka' => 'Jumat',  'jam_buka' => '09:00', 'jam_tutup' => '18:00'],
            ['mitra_id' => 4, 'hari_buka' => 'Sabtu',  'jam_buka' => '10:00', 'jam_tutup' => '16:00'],

            // Mitra ID 5
            ['mitra_id' => 5, 'hari_buka' => 'Senin',  'jam_buka' => '08:30', 'jam_tutup' => '20:30'],
            ['mitra_id' => 5, 'hari_buka' => 'Selasa', 'jam_buka' => '08:30', 'jam_tutup' => '20:30'],
            ['mitra_id' => 5, 'hari_buka' => 'Rabu',   'jam_buka' => '08:30', 'jam_tutup' => '20:30'],
            ['mitra_id' => 5, 'hari_buka' => 'Kamis',  'jam_buka' => '08:30', 'jam_tutup' => '20:30'],
            ['mitra_id' => 5, 'hari_buka' => 'Jumat',  'jam_buka' => '08:30', 'jam_tutup' => '20:30'],
            ['mitra_id' => 5, 'hari_buka' => 'Sabtu',  'jam_buka' => '09:00', 'jam_tutup' => '17:00'],
        ];

        DB::table('jam_operasional')->insert($data);
    }
}
