<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LayananSatuan;

class LayananSatuanSeeder extends Seeder
{
    public function run(): void
    {
        LayananSatuan::insert([
            ['nama_layanan' => 'Sepatu'],
            ['nama_layanan' => 'Sweater'],
            ['nama_layanan' => 'Boneka Kecil'],
            ['nama_layanan' => 'Tas Sekolah'],
            ['nama_layanan' => 'Bed Cover'],
            ['nama_layanan' => 'Jaket'],
        ]);
    }
}
