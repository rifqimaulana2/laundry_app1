<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JamOperasionalsSeeder extends Seeder
{
    public function run()
    {
        DB::table('jam_operasionals')->insert([
            // Mitra ID 1
            ['mitra_id' => 1, 'hari_buka' => 'Senin',  'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 1, 'hari_buka' => 'Selasa', 'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 1, 'hari_buka' => 'Rabu',   'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 1, 'hari_buka' => 'Kamis',  'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 1, 'hari_buka' => 'Jumat',  'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 1, 'hari_buka' => 'Sabtu',  'jam_buka' => '08:00', 'jam_tutup' => '20:00'],

            // Mitra ID 2
            ['mitra_id' => 2, 'hari_buka' => 'Senin',  'jam_buka' => '08:00', 'jam_tutup' => '21:00'],
            ['mitra_id' => 2, 'hari_buka' => 'Selasa', 'jam_buka' => '08:00', 'jam_tutup' => '21:00'],
            ['mitra_id' => 2, 'hari_buka' => 'Rabu',   'jam_buka' => '08:00', 'jam_tutup' => '21:00'],
            ['mitra_id' => 2, 'hari_buka' => 'Kamis',  'jam_buka' => '08:00', 'jam_tutup' => '21:00'],
            ['mitra_id' => 2, 'hari_buka' => 'Jumat',  'jam_buka' => '08:00', 'jam_tutup' => '21:00'],
            ['mitra_id' => 2, 'hari_buka' => 'Sabtu',  'jam_buka' => '08:00', 'jam_tutup' => '21:00'],

            // Mitra ID 3
            ['mitra_id' => 3, 'hari_buka' => 'Senin',  'jam_buka' => '09:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 3, 'hari_buka' => 'Selasa', 'jam_buka' => '09:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 3, 'hari_buka' => 'Rabu',   'jam_buka' => '09:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 3, 'hari_buka' => 'Kamis',  'jam_buka' => '09:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 3, 'hari_buka' => 'Jumat',  'jam_buka' => '09:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 3, 'hari_buka' => 'Sabtu',  'jam_buka' => '09:00', 'jam_tutup' => '20:00'],

            // Mitra ID 4
            ['mitra_id' => 4, 'hari_buka' => 'Senin',  'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 4, 'hari_buka' => 'Selasa', 'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 4, 'hari_buka' => 'Rabu',   'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 4, 'hari_buka' => 'Kamis',  'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 4, 'hari_buka' => 'Jumat',  'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
            ['mitra_id' => 4, 'hari_buka' => 'Sabtu',  'jam_buka' => '08:00', 'jam_tutup' => '20:00'],
        ]);
    }
}
