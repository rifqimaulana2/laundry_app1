<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    /**
     * Penting: di proyek ini nama tabel adalah 'pesanan' (singular)
     */
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

    /**
     * Pelanggan terdaftar (users)
     * Blade kamu pakai $pesanan->user->name
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    /**
     * Profil pelanggan (alamat, no_telepon) – tabel: pelanggan_profiles
     * Bisa dipakai jika kamu ingin akses langsung $pesanan->pelangganProfile
     * (tapi di Blade sekarang sudah aman via $pesanan->user->profile)
     */
    public function pelangganProfile()
    {
        return $this->hasOne(PelangganProfile::class, 'user_id', 'user_id')->withDefault();
    }

    /**
     * Pelanggan walk-in – tabel: walkin_customers
     * (kolom: name, no_telepon, alamat, mitra_id)
     */
    public function walkinCustomer()
    {
        return $this->belongsTo(WalkinCustomer::class, 'walkin_customer_id')->withDefault();
    }

    /**
     * Detail kiloan
     */
    public function kiloanDetails()
    {
        return $this->hasMany(PesananDetailKiloan::class, 'pesanan_id');
    }

    /**
     * Detail satuan
     */
    public function satuanDetails()
    {
        return $this->hasMany(PesananDetailSatuan::class, 'pesanan_id');
    }

    /**
     * Tagihan
     */
    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'pesanan_id');
    }
    

    /**
     * Mitra
     */
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    /**
     * Riwayat tracking status
     */
    public function trackingStatus()
    {
        return $this->hasMany(TrackingStatus::class, 'pesanan_id');
    }

    /**
     * Status terakhir (by kolom 'waktu')
     */
    public function latestStatus()
    {
        return $this->hasOne(TrackingStatus::class, 'pesanan_id')->latestOfMany('waktu');
    }

    /**
     * (Opsional) relasi riwayat transaksi jika ada tabelnya
     */
    public function riwayatTransaksi()
    {
        return $this->hasMany(RiwayatTransaksi::class, 'pesanan_id');
    }
}
