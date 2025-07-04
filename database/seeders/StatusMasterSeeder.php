<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusMasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('status_master')->insert([
            ['id' => 1, 'nama_status' => 'menunggu'],
            ['id' => 2, 'nama_status' => 'dijemput'],
            ['id' => 3, 'nama_status' => 'diproses'],
            ['id' => 4, 'nama_status' => 'selesai'],
            ['id' => 5, 'nama_status' => 'diantar'],
        ]);
    }
}
