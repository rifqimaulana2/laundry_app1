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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jamOperasional()
    {
        return $this->hasMany(JamOperasional::class);
    }

    public function layananKiloan()
    {
        return $this->hasMany(LayananMitraKiloan::class);
    }

    public function layananSatuan()
    {
        return $this->hasMany(LayananMitraSatuan::class);
    }
}
