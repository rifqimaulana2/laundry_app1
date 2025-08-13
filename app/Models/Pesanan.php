<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\WalkinCustomer;
use App\Models\Mitra;
use App\Models\Tagihan;
use App\Models\PesananDetailKiloan;
use App\Models\PesananDetailSatuan;
use App\Models\TrackingStatus;
use App\Models\PelangganProfile;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';

    protected $fillable = [
        'user_id',
        'walkin_customer_id',
        'mitra_id',
        'jenis_pesanan',
        'catatan_pesanan',
        'tipe_dp_wajib',
        'tipe_bisa_lunas',
        'tanggal_pesan',
        'opsi_jemput',
        'jadwal_jemput',
        'opsi_antar',
        'jadwal_antar',
        'catatan_pengiriman',
    ];

    // Relasi ke user (pelanggan terdaftar)
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    // Relasi ke profile pelanggan (alamat, no_telp)
    public function pelangganProfile()
    {
        return $this->hasOne(PelangganProfile::class, 'user_id', 'user_id')->withDefault();
    }

    // Relasi ke pelanggan walk-in
    public function walkinCustomer()
    {
        return $this->belongsTo(WalkinCustomer::class, 'walkin_customer_id')->withDefault();
    }

    // Detail layanan kiloan
    public function kiloanDetails()
    {
        return $this->hasMany(PesananDetailKiloan::class, 'pesanan_id');
    }

    // Detail layanan satuan
    public function satuanDetails()
    {
        return $this->hasMany(PesananDetailSatuan::class, 'pesanan_id');
    }

    // Tagihan
    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'pesanan_id');
    }

    // Mitra
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    // Riwayat status tracking
    public function trackingStatus()
    {
        return $this->hasMany(TrackingStatus::class, 'pesanan_id');
    }

    // Status terakhir (latest status by waktu)
    public function latestStatus()
    {
        return $this->hasOne(TrackingStatus::class, 'pesanan_id')->latestOfMany('waktu');
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function riwayatTransaksi()
{
    return $this->hasMany(RiwayatTransaksi::class, 'pesanan_id');
}


}
