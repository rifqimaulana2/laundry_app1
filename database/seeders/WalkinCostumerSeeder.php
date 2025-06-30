<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WalkinCostumer;

class WalkinCostumerSeeder extends Seeder
{
    public function run(): void
    {
        WalkinCostumer::insert([
            [
                'nama' => 'Joko Dirah',
                'no_tlp' => '089999888777',
                'alamat' => 'Jl. Raya Indramayu',
                'mitras_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ana',
                'no_tlp' => '089888777666',
                'alamat' => 'Jl. Sudirman No. 44',
                'mitras_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
