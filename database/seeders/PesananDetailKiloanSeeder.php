<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;
use App\Models\LayananMitraKiloan;
use App\Models\PesananDetailKiloan;

class PesananDetailKiloanSeeder extends Seeder
{
    public function run(): void
    {
        $pesananKiloans = Pesanan::whereHas('user') // hanya pelanggan terdaftar
            ->whereHas('layananKiloan') // hanya pesanan yang memang kiloan
            ->get();

        foreach ($pesananKiloans as $pesanan) {
            $layanan = LayananMitraKiloan::where('mitra_id', $pesanan->mitra_id)->inRandomOrder()->first();
            if (!$layanan) continue;

            $berat = rand(2, 5);
            $hargaPerKg = $layanan->harga_per_kg;

            PesananDetailKiloan::create([
                'pesanan_id' => $pesanan->id,
                'layanan_mitra_kiloan_id' => $layanan->id,
                'berat_sementara' => $berat,
                'berat_real' => $berat + rand(0, 1), // bisa beda sedikit
                'harga_per_kg' => $hargaPerKg,
                'subtotal' => $berat * $hargaPerKg,
            ]);
        }
    }
}
