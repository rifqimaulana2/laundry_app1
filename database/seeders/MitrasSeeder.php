<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MitrasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mitras')->insert([
            [
                'user_id' => 2,
                'nama_toko' => "Kilo's Indramayu",
                'kecamatan' => 'Indramayu',
                'alamat_lengkap' => 'Jl. Veteran No. 12',
                'longitude' => -6.3328,
                'latitude' => 108.3160,
                'foto_toko' => 'kils.png',
                'no_telepon' => '81234567800',
                'foto_profile' => 'kilos.png',
                'updated_at' => '2025-07-27',
            ],
            [
                'user_id' => 3,
                'nama_toko' => 'Tomodachi Laundry',
                'kecamatan' => 'Sindang',
                'alamat_lengkap' => 'Jl. Anggrek No. 5',
                'longitude' => -6.3305,
                'latitude' => 108.3180,
                'foto_toko' => 'chi.png',
                'no_telepon' => '82112348888',
                'foto_profile' => 'tomo.png',
                'updated_at' => '2025-07-27',
            ],
            [
                'user_id' => 4,
                'nama_toko' => "O'meh Laundry",
                'kecamatan' => 'Jatibarang',
                'alamat_lengkap' => 'Jl. KH Hasyim Ashari No. 20',
                'longitude' => -6.3330,
                'latitude' => 108.3155,
                'foto_toko' => 'meh.png',
                'no_telepon' => '85677712300',
                'foto_profile' => 'omeh.png',
                'updated_at' => '2025-07-27',
            ],
            [
                'user_id' => 5,
                'nama_toko' => 'Bebasuh Laundry',
                'kecamatan' => 'Lohbener',
                'alamat_lengkap' => 'Jl. Raya Lohbener No. 17',
                'longitude' => -6.3315,
                'latitude' => 108.3190,
                'foto_toko' => 'basuh.png',
                'no_telepon' => '89801112233',
                'foto_profile' => 'bebasuh.png',
                'updated_at' => '2025-07-27',
            ],
        ]);
    }
}
