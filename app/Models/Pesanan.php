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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function walkinCustomer()
    {
        return $this->belongsTo(WalkinCustomer::class, 'walkin_customer_id');
    }


    public function detailsKiloan()
    {
        return $this->hasMany(PesananDetailKiloan::class, 'pesanan_id');
    }

    public function detailsSatuan()
    {
        return $this->hasMany(PesananDetailSatuan::class, 'pesanan_id');
    }

    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'pesanan_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    // ✅ Relasi ke tracking status
    public function trackingStatus()
    {
        return $this->hasMany(TrackingStatus::class);
    }

    // ✅ Ambil status terakhir (latest)
    public function latestStatus()
    {
        return $this->hasOne(TrackingStatus::class)->latestOfMany('waktu');
    }


}
