<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'nama_toko',
        'alamat',
        'no_telepon',
        'kecamatan',
        'longitude',
        'latitude',
        'status_approve',
        'langganan_aktif',
        'tanggal_langganan_berakhir'
    ];

    // Relasi ke user (pemilik akun mitra)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi jam operasional mitra
    public function jamOperasional()
    {
        return $this->hasMany(JamOperasional::class);
    }

    // Relasi ke layanan kiloan milik mitra
    public function layananKiloan()
    {
        return $this->hasMany(LayananMitraKiloan::class);
    }

    // Relasi ke layanan satuan milik mitra
    public function layananSatuan()
    {
        return $this->hasMany(LayananMitraSatuan::class);
    }

    // Relasi ke langganan mitra (1:1)
    public function langgananMitra()
    {
        return $this->hasOne(LanggananMitra::class);
    }
}
