<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin Super',
                'email' => 'admin@laundry.com',
                'password' => Hash::make('12345678'),
                'role' => 'superadmin',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 0, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 0, 0),
            ],
            [
                'id' => 2,
                'name' => "Kilo's Indramayu",
                'email' => 'kilos@laundry.com',
                'password' => Hash::make('12345678'),
                'role' => 'mitra',
                'nama_usaha' => "Kilo's Laundry",
                'no_telepon' => '81234567800',
                'kecamatan' => 'Indramayu',
                'created_at' => Carbon::create(2025, 7, 1, 8, 1, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 1, 0),
            ],
            [
                'id' => 3,
                'name' => "Tomodachi Laun",
                'email' => 'tomodachi@laundry.com',
                'password' => Hash::make('12345678'),
                'role' => 'mitra',
                'nama_usaha' => 'Tomodachi Laun',
                'no_telepon' => '82112348888',
                'kecamatan' => 'Sindang',
                'created_at' => Carbon::create(2025, 7, 1, 8, 2, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 2, 0),
            ],
            [
                'id' => 4,
                'name' => "O'meh Laundry",
                'email' => 'omeh@laundry.com',
                'password' => Hash::make('12345678'),
                'role' => 'mitra',
                'nama_usaha' => "O'meh Express",
                'no_telepon' => '85677712300',
                'kecamatan' => 'Jatibarang',
                'created_at' => Carbon::create(2025, 7, 1, 8, 3, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 3, 0),
            ],
            [
                'id' => 5,
                'name' => 'Bebasuh Laundry',
                'email' => 'bebasuh@laundry.com',
                'password' => Hash::make('12345678'),
                'role' => 'mitra',
                'nama_usaha' => 'Bebasuh Premiu',
                'no_telepon' => '89801112233',
                'kecamatan' => 'Lohbener',
                'created_at' => Carbon::create(2025, 7, 1, 8, 4, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 4, 0),
            ],
            [
                'id' => 6,
                'name' => 'Dimas Arya',
                'email' => 'dimasarya@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 10, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 10, 0),
            ],
            [
                'id' => 7,
                'name' => 'Rahma Dewi',
                'email' => 'rahma.dewi@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 11, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 11, 0),
            ],
            [
                'id' => 8,
                'name' => 'Arif Kurniawan',
                'email' => 'arifkurniawan@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 12, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 12, 0),
            ],
            [
                'id' => 9,
                'name' => 'Siti Nurhaliza',
                'email' => 'sitinurhaliza@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 13, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 13, 0),
            ],
            [
                'id' => 10,
                'name' => 'Budi Santoso',
                'email' => 'budisantoso@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 14, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 14, 0),
            ],
            [
                'id' => 11,
                'name' => 'Lina Marlina',
                'email' => 'lina.marlina@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 15, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 15, 0),
            ],
            [
                'id' => 12,
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmadfauzi@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 16, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 16, 0),
            ],
            [
                'id' => 13,
                'name' => 'Devina Ayu',
                'email' => 'devina.ayu@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 17, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 17, 0),
            ],
            [
                'id' => 14,
                'name' => 'Iqbal Ramadhan',
                'email' => 'iqbalramadhan@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 18, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 18, 0),
            ],
            [
                'id' => 15,
                'name' => 'Tia Maulida',
                'email' => 'tia.maulida@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'nama_usaha' => null,
                'no_telepon' => null,
                'kecamatan' => null,
                'created_at' => Carbon::create(2025, 7, 1, 8, 19, 0),
                'updated_at' => Carbon::create(2025, 7, 1, 8, 19, 0),
            ],
        ]);

        // Assign role ke masing-masing user dari kolom 'role'
        foreach (User::all() as $user) {
            if ($user->role) {
                $user->assignRole($user->role);
            }
        }
    }
}
