<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanggananMitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_id',
        'status',
        'tanggal_mulai',
        'tanggal_berakhir'
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
}
