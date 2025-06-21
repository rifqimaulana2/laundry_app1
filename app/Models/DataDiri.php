<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDiri extends Model
{
    use HasFactory;

    protected $table = 'data_diri'; // nama tabel di database

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'no_telepon',
        'alamat',
        'latitude',
        'longitude',
        'lokasi_terdeteksi',
    ];
}
