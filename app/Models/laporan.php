<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'mitra_id',
        'user_id',
        'deskripsi',
        'bukti',
        'status',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    // Relasi ke Mitra
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    // Relasi ke User (pelapor)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
