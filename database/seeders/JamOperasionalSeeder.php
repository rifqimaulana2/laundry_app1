<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mitra;
use App\Models\JamOperasional;
use Carbon\Carbon;

class JamOperasionalSeeder extends Seeder
{
    public function run(): void
    {
        $hariDalamSeminggu = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        $jamBukaList = ['07:00', '08:00', '09:00'];
        $jamTutupList = ['17:00', '18:00', '19:00', '20:00'];

        $mitras = Mitra::all();

        foreach ($mitras as $mitra) {
            // Ambil 5 hari unik secara acak dari array hari
            $hariBuka = collect($hariDalamSeminggu)->shuffle()->take(5);

            foreach ($hariBuka as $hari) {
                JamOperasional::create([
                    'mitra_id' => $mitra->id,
                    'hari_buka' => $hari,
                    'jam_buka' => collect($jamBukaList)->random(),
                    'jam_tutup' => collect($jamTutupList)->random(),
                ]);
            }
        }
    }
}
