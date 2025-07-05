<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingStatus extends Model
{
    use HasFactory;

    protected $table = 'tracking_status';
    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'user_id',
        'mitra_id',
        'status_master_id',
        'waktu',
        'pesan'
    ];

    public function status()
    {
        return $this->belongsTo(StatusMaster::class, 'status_master_id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
}
