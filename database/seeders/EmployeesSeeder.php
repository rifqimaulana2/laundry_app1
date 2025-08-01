<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'id' => 1,
                'user_id' => 11,
                'mitra_id' => 1,
                'no_telepon' => '8972857572',
                'created_at' => Carbon::parse('2025-07-10 08:15:00'),
                'updated_at' => Carbon::parse('2025-07-24 08:00:00'),
            ],
            [
                'id' => 2,
                'user_id' => 12,
                'mitra_id' => 1,
                'no_telepon' => '8976822422',
                'created_at' => Carbon::parse('2025-07-10 08:16:00'),
                'updated_at' => Carbon::parse('2025-07-24 08:00:00'),
            ],
            [
                'id' => 3,
                'user_id' => 13,
                'mitra_id' => 2,
                'no_telepon' => '8966646222',
                'created_at' => Carbon::parse('2025-07-10 08:17:00'),
                'updated_at' => Carbon::parse('2025-07-25 08:00:00'),
            ],
            [
                'id' => 4,
                'user_id' => 14,
                'mitra_id' => 2,
                'no_telepon' => '9886522379',
                'created_at' => Carbon::parse('2025-07-10 08:18:00'),
                'updated_at' => Carbon::parse('2025-07-25 08:00:00'),
            ],
            [
                'id' => 5,
                'user_id' => 15,
                'mitra_id' => 3,
                'no_telepon' => '8976645844',
                'created_at' => Carbon::parse('2025-07-10 08:19:00'),
                'updated_at' => Carbon::parse('2025-07-24 08:00:00'),
            ],
            [
                'id' => 6,
                'user_id' => 16,
                'mitra_id' => 4,
                'no_telepon' => '8965733632',
                'created_at' => Carbon::parse('2025-07-10 08:20:00'),
                'updated_at' => Carbon::parse('2025-07-24 08:00:00'),
            ],
        ]);
    }
}
