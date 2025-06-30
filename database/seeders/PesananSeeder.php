<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Mitra;
use App\Models\WalkinCostumer;
use Illuminate\Support\Str;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        $pelangganIds = User::where('role', 'pelanggan')->pluck('id');
        $walkinIds = WalkinCostumer::pluck('id');
        $mitraIds = Mitra::pluck('id');

        for ($i = 0; $i < 5; $i++) {
            $isWalkin = rand(0, 1); // random antara user terdaftar atau walk-in
            $harga = rand(20000, 50000);
            $dp = rand(0, $harga);

            Pesanan::create([
                'user_id' => $isWalkin ? null : $pelangganIds->random(),
                'walkin_customer_id' => $isWalkin ? $walkinIds->random() : null,
                'mitra_id' => $mitraIds->random(),
                'status_pesanan' => 'menunggu',
                'status_konfirmasi' => 'belum',
                'waktu_pesan' => now()->subDays(rand(1, 5)),
                'tanggal_jemput' => now()->addDays(1),
                'tanggal_kirim' => now()->addDays(3),
                'dijemput_kurir' => ['ya', 'tidak'][rand(0, 1)],
                'diantar_kurir' => ['ya', 'tidak'][rand(0, 1)],
                'subtotal' => $harga,
                'dp' => $dp,
                'total_harga' => $harga,
                'sisa_tagihan' => $harga - $dp,
                'status_bayar' => $dp == $harga ? 'lunas' : ($dp > 0 ? 'sebagian' : 'belum'),
                'keterangan' => Str::random(20),
                'tanggal_jatuh_tempo' => now()->addDays(5),
            ]);
        }
    }
}
