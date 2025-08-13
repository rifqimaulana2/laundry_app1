<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi untuk pelanggan
    public function pelangganProfile()
    {
        return $this->hasOne(PelangganProfile::class, 'user_id');
    }

    // Relasi untuk mitra
    public function mitra()
    {
        return $this->hasOne(Mitra::class, 'user_id');
    }

    // Relasi untuk employee
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    // Semua pesanan yang dimiliki user
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    /**
     * Relasi profile universal untuk semua role
     * - pelanggan → pelangganProfile
     * - mitra → mitra
     * - employee → employee
     */
    public function profile()
    {
        if ($this->hasRole('pelanggan')) {
            return $this->hasOne(PelangganProfile::class, 'user_id');
        } elseif ($this->hasRole('mitra')) {
            return $this->hasOne(Mitra::class, 'user_id');
        } elseif ($this->hasRole('employee')) {
            return $this->hasOne(Employee::class, 'user_id');
        }

        // Default kembalikan null kalau rolenya tidak dikenali
        return $this->hasOne(PelangganProfile::class, 'user_id')->whereRaw('1=0');
    }
}
