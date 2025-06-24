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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function kiloanDetails()
    {
        return $this->hasMany(PesananDetailKiloan::class);
    }

    public function satuanDetails()
    {
        return $this->hasMany(PesananDetailSatuan::class);
    }

    public function trackingStatus()
    {
        return $this->hasMany(TrackingStatus::class);
    }
}
