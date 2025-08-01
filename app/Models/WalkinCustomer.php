<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Mitra;
use App\Models\Pesanan;

class WalkinCustomer extends Model
{
    use HasFactory;

    protected $table = 'walkin_customers';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'no_tlp',
        'alamat',
        'mitra_id', // penting agar bisa mass-assigned saat create/update
    ];

    /**
     * Relasi: WalkinCustomer dimiliki oleh satu Mitra
     */
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    /**
     * Relasi: WalkinCustomer memiliki banyak Pesanan
     */
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'walkin_customer_id');
    }
}
