<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrackingStatus;
use App\Models\Pesanan;
use App\Models\StatusMaster;
use Illuminate\Support\Str;

class TrackingStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statusList = StatusMaster::pluck('id')->toArray();

        Pesanan::all()->each(function ($pesanan) use ($statusList) {
            $steps = rand(2, count($statusList)); // misal: menunggu → dijemput → diproses
            $usedStatus = array_slice($statusList, 0, $steps);

            foreach ($usedStatus as $status_id) {
                TrackingStatus::create([
                    'pesanan_id' => $pesanan->id,
                    'user_id' => $pesanan->user_id ?? 1, // fallback ke user_id 1 jika null
                    'mitra_id' => $pesanan->mitra_id,
                    'status_master_id' => $status_id,
                    'waktu' => now()->subHours(rand(1, 72)),
                    'pesan' => Str::random(20),
                ]);
            }
        });
    }
}
