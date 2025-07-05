<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananMitraKiloan extends Model
{
    use HasFactory;

    protected $table = 'layanan_mitra_kiloan';
    public $timestamps = false;

    protected $fillable = [
        'mitra_id',
        'layanan_kiloan_id',
        'harga_per_kg'
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function layanan()
    {
        return $this->belongsTo(LayananKiloan::class, 'layanan_kiloan_id');
    }
}
