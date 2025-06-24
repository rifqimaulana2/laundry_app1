<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisLayanan;

class JenisLayananSeeder extends Seeder
{
    public function run(): void
    {
        JenisLayanan::insert([
            ['nama_layanan' => 'Kiloan'],
            ['nama_layanan' => 'Satuan'],
        ]);
    }
}
