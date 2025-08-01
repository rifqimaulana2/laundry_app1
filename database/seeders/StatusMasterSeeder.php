<?php

// database/seeders/StatusMasterSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusMasterSeeder extends Seeder
{
    public function run()
    {
        DB::table('status_master')->insert([
            ['nama_status' => 'menunggu_konfirmasi'],
            ['nama_status' => 'diproses'],
            ['nama_status' => 'dijemput'],
            ['nama_status' => 'diantar'],
            ['nama_status' => 'selesai'],
            ['nama_status' => 'dibatalkan'],
        ]);
    }
}
