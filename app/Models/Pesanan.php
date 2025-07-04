<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan'; // 👈 Tambahkan ini!

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function walkinCustomer()
    {
        return $this->belongsTo(WalkinCustomer::class); // periksa juga: seharusnya "WalkinCustomer", bukan "Costumer"?
    }

    public function kiloanDetails()
    {
        return $this->hasMany(PesananDetailKiloan::class);
    }

    public function satuanDetails()
    {
        return $this->hasMany(PesananDetailSatuan::class);
    }

    public function layananKiloan()
    {
        return $this->hasOne(PesananDetailKiloan::class);
    }

    public function layananSatuan()
    {
        return $this->hasOne(PesananDetailSatuan::class);
    }

    public function trackingStatus()
    {
        return $this->hasMany(TrackingStatus::class);
    }
}
