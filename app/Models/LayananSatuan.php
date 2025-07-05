<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananSatuan extends Model
{
    use HasFactory;

    protected $table = 'layanan_satuan';
    public $timestamps = false;

    protected $fillable = ['nama_layanan'];

    public function mitras()
    {
        return $this->hasMany(LayananMitraSatuan::class);
    }
}
