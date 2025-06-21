<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'toko_id',
        'nama',
        'telepon',
        'alamat',
        'jenis_layanan',
        'detail_layanan',
        'metode_pembayaran',
        'status',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
