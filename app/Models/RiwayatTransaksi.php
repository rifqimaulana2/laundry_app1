<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTransaksi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'keterangan', // bukan 'status' sesuai kolom database kamu
        'jumlah'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
