<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MitrasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mitras')->insert([
    [
        'id' => 2,
        'user_id' => 2,
        'nama' => "Kilo's Indramayu",
        'nama_toko' => "Kilo's Laundry",
        'alamat' => "Jl. Veteran No. 12",
        'no_telepon' => "81234567800",
        'kecamatan' => "Indramayu",
        'longitude' => "10.832.510",
        'latitude' => "-632.005",
        'status_approve' => true,
        'langganan_aktif' => true,
        'tanggal_langganan_berakhir' => '2025-12-31',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'id' => 3,
        'user_id' => 3,
        'nama' => "Tomodachi Laundry",
        'nama_toko' => "Tomodachi Laundry",
        'alamat' => "Jl. Anggrek No. 5",
        'no_telepon' => "82112348888",
        'kecamatan' => "Sindang",
        'longitude' => "10.832.810",
        'latitude' => "-632.122",
        'status_approve' => true,
        'langganan_aktif' => true,
        'tanggal_langganan_berakhir' => '2025-11-15',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'id' => 4,
        'user_id' => 4,
        'nama' => "O’meh Laundry",
        'nama_toko' => "O’meh Express",
        'alamat' => "Jl. KH Hasyim Ashari No. 20",
        'no_telepon' => "85677712300",
        'kecamatan' => "Jatibarang",
        'longitude' => "10.832.950",
        'latitude' => "-632.555",
        'status_approve' => true,
        'langganan_aktif' => true,
        'tanggal_langganan_berakhir' => '2025-09-30',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'id' => 5,
        'user_id' => 5,
        'nama' => "Bebasuh Laundry",
        'nama_toko' => "Bebasuh Premium",
        'alamat' => "Jl. Raya Lohbener No. 17",
        'no_telepon' => "89801112233",
        'kecamatan' => "Lohbener",
        'longitude' => "10.833.075",
        'latitude' => "-632.210",
        'status_approve' => true,
        'langganan_aktif' => false,
        'tanggal_langganan_berakhir' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

    }
}
