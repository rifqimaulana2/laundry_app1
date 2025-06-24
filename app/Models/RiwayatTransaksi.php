<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'status',
        'jumlah'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
