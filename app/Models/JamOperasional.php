<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JamOperasional extends Model
{
    use HasFactory;

    protected $table = 'jam_operasionals';

    protected $fillable = [
        'mitra_id',
        'hari',
        'jam_buka',
        'jam_tutup',
        'is_libur',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
}
