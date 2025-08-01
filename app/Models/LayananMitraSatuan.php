<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayananMitraSatuan extends Model
{
    use HasFactory;

    protected $table = 'layanan_mitra_satuan';

    public $timestamps = false;

    protected $fillable = [
        'layanan_satuan_id',
        'mitra_id',
        'harga_per_item',
        'durasi_hari',
    ];

    public function layananSatuan()
    {
        return $this->belongsTo(LayananSatuan::class, 'layanan_satuan_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
}
