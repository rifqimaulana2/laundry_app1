<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganProfile extends Model
{
    use HasFactory;

    protected $table = 'pelanggan_profiles';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nama',
        'no_telepon',
        'alamat',
        'kecamatan',
        'longitude',
        'latitude',
        'foto_profil',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
