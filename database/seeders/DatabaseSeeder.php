<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
public function run(): void
{
    $this->call([
        RoleSeeder::class,                     // ← Tambah di awal

        UsersSeeder::class,
        PelangganProfilesSeeder::class,
        MitrasSeeder::class,
        JamOperasionalSeeder::class,
        JenisLayananSeeder::class,
        LayananKiloanSeeder::class,
        LayananMitraKiloanSeeder::class,
        LayananSatuanSeeder::class,
        LayananMitraSatuanSeeder::class,
        WalkinCustomerSeeder::class,
        PesananSeeder::class,
        PesananDetailKiloanSeeder::class,
        PesananDetailSatuanSeeder::class,
        StatusMasterSeeder::class,
        TrackingStatusSeeder::class,
        NotifikasiSeeder::class,
        RiwayatTransaksiSeeder::class,
        TagihanPembayaranSeeder::class,

    ]);
}

}
