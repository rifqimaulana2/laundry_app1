<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role superadmin jika belum ada
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);

        // Buat user admin
        $user = User::firstOrCreate(
            ['email' => 'admin@laundry.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('12345678'),
                'role' => 'superadmin', // kalau kamu masih simpan role di kolom user
            ]
        );

        // Assign role ke user
        if (!$user->hasRole('superadmin')) {
            $user->assignRole($superadminRole);
        }
    }
}
