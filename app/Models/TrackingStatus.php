<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingStatus extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'tracking_status';

    protected $fillable = [
        'pesanan_id',
        'user_id',
        'mitra_id',
        'status_master_id',
        'waktu',
        'pesan'
    ];

    // Relasi ke master status (misalnya: "Diproses", "Selesai", dll.)
    public function status()
    {
        return $this->belongsTo(StatusMaster::class, 'status_master_id');
    }

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    // Relasi ke user (pelanggan yang memesan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke mitra (laundry store yang memproses)
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
}
