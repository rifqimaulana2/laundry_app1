<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nama_usaha',
        'no_telepon',
        'kecamatan',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel pelanggan_profiles
     */
    public function pelangganProfile()
    {
        return $this->hasOne(PelangganProfile::class);
    }

    /**
     * Relasi ke tabel mitras
     */
    public function mitra()
    {
        return $this->hasOne(Mitra::class);
    }

    /**
     * Relasi ke pesanan
     */
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    /**
     * Relasi ke notifikasi
     */
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    /**
     * Relasi ke tracking status
     */
    public function trackingStatus()
    {
        return $this->hasMany(TrackingStatus::class);
    }
}
