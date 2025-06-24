<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusMaster;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        StatusMaster::insert([
            ['nama_status' => 'Menunggu'],
            ['nama_status' => 'Dijemput'],
            ['nama_status' => 'Diproses'],
            ['nama_status' => 'Selesai'],
            ['nama_status' => 'Diantar'],
        ]);
    }
}
