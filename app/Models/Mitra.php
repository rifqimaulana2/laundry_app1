<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitras'; // Sesuai nama tabel di database
    public $timestamps = false;

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
        'tanggal_langganan_berakhir',
    ];

    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke jam operasional mitra (foreign key: mitra_id)
     */
    public function jamOperasional()
    {
        return $this->hasMany(JamOperasional::class, 'mitra_id');
    }

    /**
     * Relasi ke layanan kiloan mitra (foreign key: mitra_id)
     */
    public function layananMitraKiloan()
    {
        return $this->hasMany(LayananMitraKiloan::class, 'mitra_id');
    }

    /**
     * Relasi ke layanan satuan mitra (foreign key: mitra_id)
     */
    public function layananMitraSatuan()
    {
        return $this->hasMany(LayananMitraSatuan::class, 'mitra_id');
    }

    /**
     * Relasi ke pesanan yang dimiliki mitra (foreign key: mitras_id)
     * Pastikan kolom ini benar-benar ada di tabel pesanan
     */
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'mitras_id');
    }
}
