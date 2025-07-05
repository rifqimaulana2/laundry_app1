<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketLangganan extends Model
{
    protected $table = 'paket_langganans';
    public $timestamps = false;

    protected $fillable = ['nama_paket', 'harga', 'durasi'];
}
