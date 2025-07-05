<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanggananMitra extends Model
{
    use HasFactory;

    protected $table = 'langganan_mitra';
    public $timestamps = false;

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
