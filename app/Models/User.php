<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Hidden attributes for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke profil pelanggan
    public function pelangganProfile()
    {
        return $this->hasOne(PelangganProfile::class);
    }

    // Relasi ke mitra
    public function mitra()
    {
        return $this->hasOne(Mitra::class);
    }

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    // Relasi ke notifikasi
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    // Relasi ke tracking status
    public function trackingStatus()
    {
        return $this->hasMany(TrackingStatus::class);
    }
}
