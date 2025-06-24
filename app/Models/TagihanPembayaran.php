<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'jumlah_tagihan',
        'sisa_tagihan',
        'status_bayar'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
