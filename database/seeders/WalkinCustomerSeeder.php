<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalkinCustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('walkin_customers')->insert([
            [
                'nama' => 'Rudi Hartono',
                'no_tlp' => '81212121212',
                'alamat' => 'Jl. Merpati No. 5',
                'mitra_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ayu Lestari',
                'no_tlp' => '82112345666',
                'alamat' => 'Jl. Anggrek No. 8',
                'mitra_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dedi Supriyadi',
                'no_tlp' => '81298765432',
                'alamat' => 'Perum Griya Indah Blok B1',
                'mitra_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
