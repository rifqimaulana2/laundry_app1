<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananKiloan extends Model
{
    use HasFactory;

    protected $table = 'layanan_kiloan';
    public $timestamps = false;

    protected $fillable = ['id', 'nama_paket', 'durasi_hari'];

    public function mitras()
    {
        return $this->hasMany(LayananMitraKiloan::class);
    }
}
