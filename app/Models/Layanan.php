<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = ['toko_id', 'nama_layanan', 'harga'];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
