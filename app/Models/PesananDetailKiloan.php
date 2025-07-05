<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetailKiloan extends Model
{
    use HasFactory;

    protected $table = 'pesanan_detail_kiloan';
    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'layanan_mitra_kiloan_id',
        'berat_sementara',
        'berat_real',
        'harga_per_kg',
        'subtotal'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function layananMitraKiloan()
    {
        return $this->belongsTo(\App\Models\LayananMitraKiloan::class, 'layanan_mitra_kiloan_id');
    }
}
