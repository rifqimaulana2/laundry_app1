<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalkinCustomer extends Model
{
    use HasFactory;

    protected $table = 'walkin_customers';

    public $timestamps = false;

    /**
     * Sesuai SQL terbaru: name, no_telepon, alamat, mitra_id
     */
    protected $fillable = [
        'name',
        'no_telepon',
        'alamat',
        'mitra_id',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'walkin_customer_id');
    }
}
