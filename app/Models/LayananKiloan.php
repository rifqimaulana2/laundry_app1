<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananKiloan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket',
        'harga_per_kg',
        'durasi_hari'
    ];

    public function mitras()
    {
        return $this->hasMany(LayananMitraKiloan::class);
    }
}
