<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mitra;
use App\Models\LayananMitraSatuan;
use App\Models\LayananMitraKiloan;
use App\Models\LayananSatuan;
use App\Models\LayananKiloan;

class LayananMitraSeeder extends Seeder
{
    public function run(): void
    {
        $mitras = Mitra::all();
        $layananSatuans = LayananSatuan::all();
        $layananKiloans = LayananKiloan::all();

        foreach ($mitras as $mitra) {
            // untuk layanan kiloan
            foreach ($layananKiloans as $layanan) {
                LayananMitraKiloan::create([
                    'mitra_id' => $mitra->id,
                    'layanan_kiloan_id' => $layanan->id,
                    'harga_per_kg' => rand(6000, 12000),
                ]);
            }

            // untuk layanan satuan
            foreach ($layananSatuans as $layanan) {
                LayananMitraSatuan::create([
                    'mitra_id' => $mitra->id,
                    'layanan_satuan_id' => $layanan->id,
                    'harga_per_item' => rand(10000, 40000),
                ]);
            }
        }
    }
}
