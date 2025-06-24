<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PelangganProfile;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggans = [
            ['name' => 'Budi Santoso', 'email' => 'budi@pelanggan.com'],
            ['name' => 'Ani Lestari', 'email' => 'ani@pelanggan.com'],
            ['name' => 'Rina Marlina', 'email' => 'rina@pelanggan.com'],
            ['name' => 'Joko Widodo', 'email' => 'joko@pelanggan.com'],
        ];

        foreach ($pelanggans as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
            ]);

            PelangganProfile::create([
                'user_id' => $user->id,
                'nama' => $data['name'],
                'alamat' => 'Jl. Contoh No. ' . rand(1, 100),
                'no_telepon' => '08' . rand(111111111, 999999999),
                'longitude' => '-108.123456',
                'latitude' => '6.789123',
                'foto_profil' => 'default.jpg',
            ]);
        }
    }
}
