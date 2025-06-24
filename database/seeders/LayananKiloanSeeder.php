<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LayananKiloan;

class LayananKiloanSeeder extends Seeder
{
    public function run(): void
    {
        LayananKiloan::insert([
            [
                'nama_paket' => 'Reguler',
                'durasi_hari' => 2,
                'harga_per_kg' => 7000,
            ],
            [
                'nama_paket' => 'Ekspres',
                'durasi_hari' => 1,
                'harga_per_kg' => 10000,
            ],
        ]);
    }
}
