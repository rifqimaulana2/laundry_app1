<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayananMitraKiloan extends Model
{
    use HasFactory;

    protected $table = 'layanan_mitra_kiloan';

    public $timestamps = false;

    protected $fillable = [
        'layanan_kiloan_id',
        'mitra_id',
        'harga_per_kg',
        'durasi_hari',
    ];

    public function layananKiloan()
    {
        return $this->belongsTo(LayananKiloan::class, 'layanan_kiloan_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
    
}
