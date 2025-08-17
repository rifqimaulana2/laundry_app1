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

    /**
     * Profil pelanggan (alamat, no_telepon, dsb) – tabel: pelanggan_profiles
     */
    public function pelangganProfile()
    {
        return $this->hasOne(PelangganProfile::class, 'user_id');
    }

    /**
     * Relasi mitra (jika user adalah mitra)
     */
    public function mitra()
    {
        return $this->hasOne(Mitra::class, 'user_id');
    }

    /**
     * Relasi employee (jika user adalah employee)
     */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    /**
     * Semua pesanan milik user (sebagai pelanggan terdaftar)
     */
    public function pesanans()
    {
        // NB: nama tabel di DB = 'pesanan' (singular), tapi kunci asing tetap 'user_id'
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    /**
     * Getter "profile" yang compatible dengan Blade kamu:
     * - pelanggan  → PelangganProfile
     * - mitra      → Mitra
     * - employee   → Employee
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

        // default: kembalikan relasi kosong agar tidak error saat dipanggil di Blade
        return $this->hasOne(PelangganProfile::class, 'user_id')->whereRaw('1=0');
    }
}
