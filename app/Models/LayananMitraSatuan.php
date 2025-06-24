<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananMitraSatuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_id',
        'layanan_satuan_id',
        'harga_per_item'
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function layanan()
    {
        return $this->belongsTo(LayananSatuan::class, 'layanan_satuan_id');
    }
}
