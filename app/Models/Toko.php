<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = ['nama_toko', 'alamat', 'telepon'];

    /**
     * Relasi: Satu toko memiliki banyak layanan
     */
    public function layanans()
    {
        return $this->hasMany(Layanan::class);
    }
}
