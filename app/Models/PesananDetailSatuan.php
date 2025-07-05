<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetailSatuan extends Model
{
    use HasFactory;

    protected $table = 'pesanan_detail_satuan';
    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'layanan_mitra_satuan_id',
        'jumlah_item',
        'harga_per_item',
        'subtotal'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    // Default relasi (lama)
    public function layanan()
    {
        return $this->belongsTo(\App\Models\LayananMitraSatuan::class, 'layanan_mitra_satuan_id');
    }

    // Relasi alternatif jika kamu panggil dengan nama "layananMitraSatuan"
    public function layananMitraSatuan()
    {
        return $this->belongsTo(\App\Models\LayananMitraSatuan::class, 'layanan_mitra_satuan_id');
    }
}
