<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mitra extends Model
{
    protected $fillable = [
        'user_id',
        'nama_toko',
        'kecamatan',
        'alamat_lengkap',
        'longitude',
        'latitude',
        'foto_toko',
        'no_telepon',
        'status_approve',
        'foto_profile',
    ];

    // Relasi ke tabel users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke layanan kiloan
    public function layananMitraKiloan()
    {
        return $this->hasMany(\App\Models\LayananMitraKiloan::class);
    }

    // Relasi ke layanan satuan
    public function layananMitraSatuan()
    {
        return $this->hasMany(\App\Models\LayananMitraSatuan::class);
    }

    // Relasi ke jam operasional
    public function jamOperasionals()
    {
        return $this->hasMany(\App\Models\JamOperasional::class);
    }

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->hasMany(\App\Models\Pesanan::class);
    }

    // Scope mitra pending
    public function scopePending($query)
    {
        return $query->where('status_approve', 'pending');
    }

    // Scope mitra disetujui
    public function scopeDisetujui($query)
    {
        return $query->where('status_approve', 'disetujui');
    }

    // Scope mitra ditolak
    public function scopeDitolak($query)
    {
        return $query->where('status_approve', 'ditolak');
    }
}
