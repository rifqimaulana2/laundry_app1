<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'user_id',
        'judul',
        'aktivitas',
        'status_baca'
    ];

    protected $casts = [
        'created_at' => 'datetime', // ✅ tambahkan ini
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
