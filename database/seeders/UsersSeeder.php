<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin Super', 'email' => 'admin@laundry.com', 'password' => '12345678', 'role' => 'superadmin', 'created_at' => '2025-07-10 08:00:00'],
            ['name' => "Kilo's Indramayu", 'email' => 'kilos@laundry.com', 'password' => '12345678', 'role' => 'mitra', 'created_at' => '2025-07-10 08:01:00'],
            ['name' => 'Tomodachi Laundry', 'email' => 'tomodachi@laundry.com', 'password' => '12345678', 'role' => 'mitra', 'created_at' => '2025-07-10 08:02:00'],
            ['name' => "O'meh Laundry", 'email' => 'omeh@laundry.com', 'password' => '12345678', 'role' => 'mitra', 'created_at' => '2025-07-10 08:03:00'],
            ['name' => 'Bebasuh Laundry', 'email' => 'bebasuh@laundry.com', 'password' => '12345678', 'role' => 'mitra', 'created_at' => '2025-07-10 08:04:00'],
            ['name' => 'Dimas Arya', 'email' => 'dimasarya@gmail.com', 'password' => '12345678', 'role' => 'pelanggan', 'created_at' => '2025-07-10 08:10:00'],
            ['name' => 'Rahma Dewi', 'email' => 'rahma.dewi@gmail.com', 'password' => '12345678', 'role' => 'pelanggan', 'created_at' => '2025-07-10 08:11:00'],
            ['name' => 'Arif Kurniawan', 'email' => 'arifkurniawan@gmail.com', 'password' => '12345678', 'role' => 'pelanggan', 'created_at' => '2025-07-10 08:12:00'],
            ['name' => 'Siti Nurhaliza', 'email' => 'sitinurhaliza@gmail.com', 'password' => '12345678', 'role' => 'pelanggan', 'created_at' => '2025-07-10 08:13:00'],
            ['name' => 'Budi Santoso', 'email' => 'budisantoso@gmail.com', 'password' => '12345678', 'role' => 'pelanggan', 'created_at' => '2025-07-10 08:14:00'],
            ['name' => 'Lia Maryani', 'email' => 'lia@gmail.com', 'password' => '12345678', 'role' => 'employee', 'created_at' => '2025-07-10 08:15:00'],
            ['name' => 'Agung Wahyudi', 'email' => 'agung@gmail.com', 'password' => '12345678', 'role' => 'employee', 'created_at' => '2025-07-10 08:16:00'],
            ['name' => 'Ciyani', 'email' => 'ciya@gmail.com', 'password' => '12345678', 'role' => 'employee', 'created_at' => '2025-07-10 08:17:00'],
            ['name' => 'Ristyana', 'email' => 'risty@gmail.com', 'password' => '12345678', 'role' => 'employee', 'created_at' => '2025-07-10 08:18:00'],
            ['name' => 'Bela Santika', 'email' => 'bela@gmail.com', 'password' => '12345678', 'role' => 'employee', 'created_at' => '2025-07-10 08:19:00'],
            ['name' => 'Agnes', 'email' => 'agnes@gmail.com', 'password' => '12345678', 'role' => 'employee', 'created_at' => '2025-07-10 08:26:00'],
            ['name' => 'alya', 'email' => 'alya@gmail.com', 'password' => '12345678', 'role' => 'pelanggan', 'created_at' => '2025-07-10 08:29:00'],
            ['name' => 'belva', 'email' => 'belva@gmail.com', 'password' => '12345678', 'role' => 'pelanggan', 'created_at' => '2025-07-10 09:26:00'],
            ['name' => 'niara', 'email' => 'niara@gmail.com', 'password' => '12345678', 'role' => 'pelanggan', 'created_at' => '2025-07-10 09:46:00'],
        ];

        foreach ($users as $data) {
            // Normalisasi role (employee mungkin ditulis 'Employee')
            $normalizedRole = strtolower($data['role']);

            // Buat atau ambil user
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => $normalizedRole,
                    'created_at' => Carbon::parse($data['created_at']),
                ]
            );

            // Assign Spatie role jika belum ada
            if (Role::where('name', $normalizedRole)->exists() && !$user->hasRole($normalizedRole)) {
                $user->assignRole($normalizedRole);
            }
        }
    }
}
