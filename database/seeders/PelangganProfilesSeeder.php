<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganProfilesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pelanggan_profiles')->insert([
            [
                'id' => 1,
                'user_id' => 6,
                'nama' => 'Dimas Arya',
                'alamat' => 'Jl. Melati No. 15',
                'no_telepon' => '81.234.567.890',
                'longitude' => '10.832.451',
                'latitude' => '-632.615',
                'kecamatan' => 'Indramayu',
                'foto_profil' => 'dimas.jpg',
            ],
            [
                'id' => 2,
                'user_id' => 7,
                'nama' => 'Rahma Dewi',
                'alamat' => 'Gg. Kenanga No. 7',
                'no_telepon' => '82.112.345.678',
                'longitude' => '10.832.598',
                'latitude' => '-632.891',
                'kecamatan' => 'Sindang',
                'foto_profil' => 'rahma.jpg',
            ],
            [
                'id' => 3,
                'user_id' => 8,
                'nama' => 'Arif Kurniawan',
                'alamat' => 'Jl. Siliwangi No. 20',
                'no_telepon' => '89.876.543.210',
                'longitude' => '10.832.643',
                'latitude' => '-633.012',
                'kecamatan' => 'Lohbener',
                'foto_profil' => 'arif.png',
            ],
            [
                'id' => 4,
                'user_id' => 9,
                'nama' => 'Siti Nurhaliza',
                'alamat' => 'Jl. Pahlawan No. 10',
                'no_telepon' => '81.298.765.432',
                'longitude' => '10.832.011',
                'latitude' => '-632.251',
                'kecamatan' => 'Jatibarang',
                'foto_profil' => 'siti.jpg',
            ],
            [
                'id' => 5,
                'user_id' => 10,
                'nama' => 'Budi Santoso',
                'alamat' => 'Perum Griya Asri Blok A3 No.2',
                'no_telepon' => '85.712.345.678',
                'longitude' => '10.832.188',
                'latitude' => '-632.790',
                'kecamatan' => 'Indramayu',
                'foto_profil' => 'budi.jpg',
            ],
            [
                'id' => 6,
                'user_id' => 11,
                'nama' => 'Lina Marlina',
                'alamat' => 'Jl. Diponegoro No. 55',
                'no_telepon' => '81.234.678.901',
                'longitude' => '10.831.990',
                'latitude' => '-632.500',
                'kecamatan' => 'Sindang',
                'foto_profil' => 'lina.jpg',
            ],
            [
                'id' => 7,
                'user_id' => 12,
                'nama' => 'Ahmad Fauzi',
                'alamat' => 'Jl. Raya Karangampel',
                'no_telepon' => '82.134.567.890',
                'longitude' => '10.831.050',
                'latitude' => '-633.345',
                'kecamatan' => 'Karangampel',
                'foto_profil' => 'ahmad.jpg',
            ],
            [
                'id' => 8,
                'user_id' => 13,
                'nama' => 'Devina Ayu',
                'alamat' => 'Jl. Cemara No. 12',
                'no_telepon' => '81.267.891.234',
                'longitude' => '10.832.987',
                'latitude' => '-632.089',
                'kecamatan' => 'Balongan',
                'foto_profil' => 'devina.jpg',
            ],
            [
                'id' => 9,
                'user_id' => 14,
                'nama' => 'Iqbal Ramadhan',
                'alamat' => 'Jl. MT Haryono No. 33',
                'no_telepon' => '89.901.234.567',
                'longitude' => '10.831.750',
                'latitude' => '-633.222',
                'kecamatan' => 'Jatibarang',
                'foto_profil' => 'iqbal.jpg',
            ],
            [
                'id' => 10,
                'user_id' => 15,
                'nama' => 'Tia Maulida',
                'alamat' => 'Gg. Mawar No. 3',
                'no_telepon' => '82.345.678.912',
                'longitude' => '10.831.875',
                'latitude' => '-632.834',
                'kecamatan' => 'Lohbener',
                'foto_profil' => 'tia.jpg',
            ],
        ]);
    }
}
