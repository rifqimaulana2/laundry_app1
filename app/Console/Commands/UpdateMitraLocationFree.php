<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mitra;
use Illuminate\Support\Facades\Http;

class UpdateMitraLocationFree extends Command
{
    protected $signature = 'mitra:update-location-free';
    protected $description = 'Update alamat mitra secara otomatis dari koordinat menggunakan OpenStreetMap API';

    public function handle()
    {
        $mitras = Mitra::all();

        foreach ($mitras as $mitra) {
            if (!$mitra->latitude || !$mitra->longitude) {
                $this->warn("⚠ {$mitra->nama_toko} tidak punya koordinat.");
                continue;
            }

            $lat = $mitra->latitude;
            $lng = $mitra->longitude;

            $url = "https://nominatim.openstreetmap.org/reverse?lat={$lat}&lon={$lng}&format=json";

            $response = Http::withHeaders([
                'User-Agent' => 'LaundryKuyApp/1.0'
            ])->get($url)->json();

            if (!empty($response['display_name'])) {
                $mitra->formatted_address = $response['display_name'];
                $mitra->save();
                $this->info("✅ {$mitra->nama_toko} -> {$response['display_name']}");
            } else {
                $this->warn("⚠ {$mitra->nama_toko} gagal mendapatkan alamat.");
            }

            // Jeda 1 detik untuk menghormati aturan OSM
            sleep(1);
        }

        $this->info('Selesai update semua mitra.');
    }
}
