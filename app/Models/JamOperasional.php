<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamOperasional extends Model
{
    use HasFactory;

    protected $table = 'jam_operasional';
    public $timestamps = false;

    protected $fillable = [
        'mitra_id',
        'hari_buka',
        'jam_buka',
        'jam_tutup'
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
}
