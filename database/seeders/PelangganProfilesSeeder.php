<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PelangganProfilesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pelanggan_profiles')->insert([
            [
                'user_id' => 6,
                'alamat' => 'Jl. Melati No. 15',
                'no_telepon' => '81.234.567.890',
                'foto_profil' => 'dimas.jpg',
                'updated_at' => Carbon::createFromFormat('d/m/Y', '24/07/2025')
            ],
            [
                'user_id' => 7,
                'alamat' => 'Gg. Kenanga No. 7',
                'no_telepon' => '82.112.345.678',
                'foto_profil' => 'rahma.jpg',
                'updated_at' => Carbon::createFromFormat('d/m/Y', '25/07/2025')
            ],
            [
                'user_id' => 8,
                'alamat' => 'Jl. Siliwangi No. 20',
                'no_telepon' => '89.876.543.210',
                'foto_profil' => 'arif.png',
                'updated_at' => Carbon::createFromFormat('d/m/Y', '24/07/2025')
            ],
            [
                'user_id' => 9,
                'alamat' => 'Jl. Pahlawan No. 10',
                'no_telepon' => '81.298.765.432',
                'foto_profil' => 'siti.jpg',
                'updated_at' => Carbon::createFromFormat('d/m/Y', '25/07/2025')
            ],
            [
                'user_id' => 10,
                'alamat' => 'Perum Griya Asri Blok A3 No.2',
                'no_telepon' => '85.712.345.678',
                'foto_profil' => 'budi.jpg',
                'updated_at' => Carbon::createFromFormat('d/m/Y', '27/07/2025')
            ],
            [
                'user_id' => 17,
                'alamat' => 'jl.kenanga sriraja',
                'no_telepon' => '8975564333',
                'foto_profil' => 'alya.jpg',
                'updated_at' => Carbon::createFromFormat('d/m/Y', '27/07/2025')
            ],
            [
                'user_id' => 18,
                'alamat' => 'jl.merdekakan bumi',
                'no_telepon' => '994748833',
                'foto_profil' => 'belva.jpg',
                'updated_at' => Carbon::createFromFormat('d/m/Y', '27/07/2025')
            ],
            [
                'user_id' => 19,
                'alamat' => 'Gg. walet 2 kencana',
                'no_telepon' => '898764474',
                'foto_profil' => 'niara.jpg',
                'updated_at' => Carbon::createFromFormat('d/m/Y', '27/07/2025')
            ],
        ]);
    }
}
