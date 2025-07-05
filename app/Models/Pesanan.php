<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'walkin_customer_id',
        'mitra_id',
        'jenis_pesanan',
        'status_pesanan',
        'status_konfirmasi',
        'status_harga',
        'status_bayar',
        'dp',
        'total_harga',
        'sisa_tagihan',
        'waktu_pesan',
        'tanggal_jemput',
        'tanggal_kirim',
        'dijemput_kurir',
        'diantar_kurir',
        'keterangan',
        'jatuh_tempo',
    ];

    // Relasi ke User (pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke data profil pelanggan
    public function pelangganProfile()
    {
        return $this->belongsTo(\App\Models\PelangganProfile::class, 'user_id', 'user_id');
    }

    // Relasi ke mitra
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    // Relasi ke walk-in customer
    public function walkinCustomer()
    {
        return $this->belongsTo(WalkinCustomer::class);
    }

    // Detail pesanan kiloan (banyak)
    public function pesananDetailKiloan()
    {
        return $this->hasMany(\App\Models\PesananDetailKiloan::class);
    }

    // Detail pesanan satuan (banyak)
    public function pesananDetailSatuan()
    {
        return $this->hasMany(\App\Models\PesananDetailSatuan::class);
    }

    // Tracking status
    public function trackingStatus()
    {
        return $this->hasMany(TrackingStatus::class);
    }
}
