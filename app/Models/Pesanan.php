<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'walkin_customer_id',
        'mitra_id',
        'status_pesanan',
        'status_konfirmasi',
        'waktu_pesan',
        'tanggal_jemput',
        'tanggal_kirim',
        'dijemput_kurir',
        'diantar_kurir',
        'subtotal',
        'dp',
        'total_harga',
        'sisa_tagihan',
        'status_bayar',
        'keterangan',
        'tanggal_jatuh_tempo'
    ];

    // Relasi ke user (pelanggan yang terdaftar)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke mitra (laundry store)
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    // Relasi ke pelanggan walk-in (tidak punya akun)
    public function walkinCustomer()
    {
        return $this->belongsTo(WalkinCostumer::class);
    }

    // Relasi untuk detail layanan kiloan (banyak item)
    public function kiloanDetails()
    {
        return $this->hasMany(PesananDetailKiloan::class);
    }

    // Relasi untuk detail layanan satuan (banyak item)
    public function satuanDetails()
    {
        return $this->hasMany(PesananDetailSatuan::class);
    }

    // Untuk ambil salah satu layanan kiloan (misalnya preview atau ringkasan)
    public function layananKiloan()
    {
        return $this->hasOne(PesananDetailKiloan::class);
    }

    // Untuk ambil salah satu layanan satuan
    public function layananSatuan()
    {
        return $this->hasOne(PesananDetailSatuan::class);
    }

    // Relasi ke tracking status (histori pengiriman/proses)
    public function trackingStatus()
    {
        return $this->hasMany(TrackingStatus::class);
    }
}
