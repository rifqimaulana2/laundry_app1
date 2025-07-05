<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalkinCustomer extends Model
{
    use HasFactory;

    protected $table = 'walkin_customer';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'no_tlp',
        'alamat',
        'mitras_id',
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'walkin_customer_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitras_id');
    }
}
