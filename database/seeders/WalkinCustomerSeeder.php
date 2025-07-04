<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalkinCustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('walkin_customer')->insert([
            [
                'nama' => 'Rudi Hartono',
                'no_tlp' => '81212121212',
                'alamat' => 'Jl. Merpati No. 5',
                'mitras_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ayu Lestari',
                'no_tlp' => '82112345666',
                'alamat' => 'Jl. Anggrek No. 8',
                'mitras_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dedi Supriyadi',
                'no_tlp' => '81298765432',
                'alamat' => 'Perum Griya Indah Blok B1',
                'mitras_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Nina Marlina',
                'no_tlp' => '82233445566',
                'alamat' => 'Jl. Sisingamangaraja No. 33',
                'mitras_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Eko Purnomo',
                'no_tlp' => '81345678901',
                'alamat' => 'Gg. Cempaka No. 7',
                'mitras_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sri Wahyuni',
                'no_tlp' => '89998877665',
                'alamat' => 'Jl. KH Wahid Hasyim No. 1',
                'mitras_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
