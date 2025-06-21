<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'mitra']);
        Role::firstOrCreate(['name' => 'pelanggan']);
        Role::firstOrCreate(['name' => 'superadmin']); // Jika perlu
    }
}
