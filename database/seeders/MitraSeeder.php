<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mitra;
use App\Models\JamOperasional;
use App\Models\LayananKiloan;
use App\Models\LayananSatuan;
use App\Models\LayananMitraKiloan;
use App\Models\LayananMitraSatuan;
use Illuminate\Support\Facades\Hash;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_toko' => "Kilo's Laundry - Indramayu", 'alamat' => 'jl. jend. sudirman indramayu', 'kecamatan' => 'Indramayu'],
            ['nama_toko' => "Tomodachi Laundry", 'alamat' => 'jl. jend sudirman no 144 lemahmekar', 'kecamatan' => 'Indramayu'],
            ['nama_toko' => "Omeh Laundry", 'alamat' => 'wisma an nur ruko no 1 karangmalang', 'kecamatan' => 'Indramayu'],
            ['nama_toko' => "Bebasuh Coin Laundry", 'alamat' => 'jl dharma ayu dermayu', 'kecamatan' => 'Sindang'],
            ['nama_toko' => "Kino Laundry", 'alamat' => 'jl cimanuk barat no 32 sindang', 'kecamatan' => 'Sindang'],
            ['nama_toko' => "Kilo's Laundry Sindang", 'alamat' => 'jl cimanuk barat no 2 sindang', 'kecamatan' => 'Sindang'],
            ['nama_toko' => "Shayn Laundry", 'alamat' => 'samping stikes indramayu jl wirapati', 'kecamatan' => 'Sindang'],
            ['nama_toko' => "Laundry Ibu Ilah", 'alamat' => 'desa lohbener blok cangkring', 'kecamatan' => 'Lohbener'],
            ['nama_toko' => "Amanah Laundry", 'alamat' => 'rambatan kulon blok bangkir kunir', 'kecamatan' => 'Lohbener'],
            ['nama_toko' => "Awan Laundry", 'alamat' => 'jl raya lohbener', 'kecamatan' => 'Lohbener'],
        ];

        foreach ($data as $i => $mitraData) {
            // Buat user role mitra
            $user = User::create([
                'name' => $mitraData['nama_toko'],
                'email' => 'mitra' . $i . '@laundry.test',
                'password' => Hash::make('password'),
                'role' => 'mitra',
            ]);

            // Buat mitra
            $mitra = Mitra::create([
                'user_id' => $user->id,
                'nama' => $user->name,
                'nama_toko' => $mitraData['nama_toko'],
                'alamat' => $mitraData['alamat'],
                'kecamatan' => $mitraData['kecamatan'],
                'no_telepon' => '08' . rand(111111111, 999999999),
            ]);

            // Buat jam operasional acak 5 hari
            $hariBuka = collect(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'])->shuffle()->take(5);
            foreach ($hariBuka as $hari) {
                JamOperasional::create([
                    'mitra_id' => $mitra->id,
                    'hari_buka' => $hari,
                    'jam_buka' => '08:00',
                    'jam_tutup' => '21:00',
                ]);
            }

            // Hubungkan ke layanan kiloan (2 paket)
            foreach (LayananKiloan::all() as $layanan) {
                LayananMitraKiloan::create([
                    'mitra_id' => $mitra->id,
                    'layanan_kiloan_id' => $layanan->id,
                    'harga_per_kg' => rand(5000, 9000),
                ]);
            }

            // Hubungkan ke layanan satuan (6 item)
            foreach (LayananSatuan::all() as $layanan) {
                LayananMitraSatuan::create([
                    'mitra_id' => $mitra->id,
                    'layanan_satuan_id' => $layanan->id,
                    'harga_per_item' => rand(10000, 25000),
                ]);
            }
        }
    }
}
