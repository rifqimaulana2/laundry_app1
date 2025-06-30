<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;
use App\Models\LayananMitraSatuan;
use App\Models\PesananDetailSatuan;

class PesananDetailSatuanSeeder extends Seeder
{
    public function run(): void
    {
        $pesananSatuans = Pesanan::whereHas('walkinCustomer') // hanya untuk walk-in
            ->whereHas('layananSatuan') // hanya yang satuan
            ->get();

        foreach ($pesananSatuans as $pesanan) {
            $layanan = LayananMitraSatuan::where('mitra_id', $pesanan->mitra_id)->inRandomOrder()->first();
            if (!$layanan) continue;

            $jumlah = rand(1, 3);
            $hargaPerItem = $layanan->harga_per_item;

            PesananDetailSatuan::create([
                'pesanan_id' => $pesanan->id,
                'layanan_mitra_satuan_id' => $layanan->id,
                'jumlah_item' => $jumlah,
                'harga_per_item' => $hargaPerItem,
                'subtotal' => $jumlah * $hargaPerItem,
            ]);
        }
    }
}
