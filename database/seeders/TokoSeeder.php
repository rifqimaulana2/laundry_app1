<?php

namespace Database\Seeders;

use App\Models\Toko;
use Illuminate\Database\Seeder;

class TokoSeeder extends Seeder
{
    public function run(): void
    {
        $tokos = [
            ['nama' => 'Kemuning', 'slug' => 'kemuning', 'alamat' => 'Jl. Kemuning No. 123', 'kontak' => '08123456789', 'gambar' => 'kemuning.jpg', 'lat' => -6.2001, 'lng' => 106.8167, 'kecamatan' => 'Ciputat'],
            ['nama' => 'Melati', 'slug' => 'melati', 'alamat' => 'Jl. Melati Indah No. 45', 'kontak' => '08123456790', 'gambar' => 'melati.jpg', 'lat' => -6.1995, 'lng' => 106.8202, 'kecamatan' => 'Ciputat'],
            ['nama' => 'Mawar', 'slug' => 'mawar', 'alamat' => 'Jl. Mawar Baru No. 9', 'kontak' => '08123456791', 'gambar' => 'mawar.jpg', 'lat' => -6.2010, 'lng' => 106.8120, 'kecamatan' => 'Ciputat'],
            ['nama' => 'Sakura', 'slug' => 'sakura', 'alamat' => 'Jl. Sakura Raya No. 99', 'kontak' => '08123456792', 'gambar' => 'sakura.jpg', 'lat' => -6.1979, 'lng' => 106.8180, 'kecamatan' => 'Pamulang'],
            ['nama' => 'Kenanga', 'slug' => 'kenanga', 'alamat' => 'Jl. Kenanga No. 27', 'kontak' => '08123456793', 'gambar' => 'kenanga.jpg', 'lat' => -6.2021, 'lng' => 106.8155, 'kecamatan' => 'Pamulang'],
            ['nama' => 'Anggrek', 'slug' => 'anggrek', 'alamat' => 'Jl. Anggrek Timur No. 88', 'kontak' => '08123456794', 'gambar' => 'anggrek.jpg', 'lat' => -6.2040, 'lng' => 106.8190, 'kecamatan' => 'Serpong'],
            ['nama' => 'Bougenville', 'slug' => 'bougenville', 'alamat' => 'Jl. Bougenville Selatan No. 21', 'kontak' => '08123456795', 'gambar' => 'bougenville.jpg', 'lat' => -6.2050, 'lng' => 106.8111, 'kecamatan' => 'Serpong'],
            ['nama' => 'Teratai', 'slug' => 'teratai', 'alamat' => 'Jl. Teratai Merah No. 33', 'kontak' => '08123456796', 'gambar' => 'teratai.jpg', 'lat' => -6.1965, 'lng' => 106.8170, 'kecamatan' => 'Serpong'],
            ['nama' => 'Kamboja', 'slug' => 'kamboja', 'alamat' => 'Jl. Kamboja Tengah No. 5', 'kontak' => '08123456797', 'gambar' => 'kamboja.jpg', 'lat' => -6.1987, 'lng' => 106.8144, 'kecamatan' => 'Cisauk'],
            ['nama' => 'Cempaka', 'slug' => 'cempaka', 'alamat' => 'Jl. Cempaka Putih No. 101', 'kontak' => '08123456798', 'gambar' => 'cempaka.jpg', 'lat' => -6.2005, 'lng' => 106.8210, 'kecamatan' => 'Cisauk'],
        ];

        foreach ($tokos as $toko) {
            Toko::updateOrCreate(['slug' => $toko['slug']], $toko);
        }
    }
}