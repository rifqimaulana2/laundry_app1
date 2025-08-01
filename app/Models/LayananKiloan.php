<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayananKiloan extends Model
{
    use HasFactory;

    protected $table = 'layanan_kiloan';

    public $timestamps = false;

    protected $fillable = [
        'jenis_layanan_id',
        'nama_paket',
    ];

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'jenis_layanan_id');
    }
}
