<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesananDetailSatuan extends Model
{
    use HasFactory;

    protected $table = 'pesanan_detail_satuan';

    protected $fillable = [
        'pesanan_id',
        'layanan_mitra_satuan_id',
        'jumlah_item',
        'harga_per_item',
        'subtotal',
    ];

    /**
     * RELASI: ke pesanan
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * RELASI: ke layanan mitra satuan
     */
    public function layananMitraSatuan()
    {
        return $this->belongsTo(LayananMitraSatuan::class);
    }

    /**
     * Setter otomatis saat jumlah_item diisi
     */
    public function setJumlahItemAttribute($value)
    {
        $this->attributes['jumlah_item'] = $value;

        if (isset($this->attributes['harga_per_item'])) {
            $this->attributes['subtotal'] = $value * $this->attributes['harga_per_item'];
        }
    }

    /**
     * Setter otomatis saat harga_per_item diisi
     */
    public function setHargaPerItemAttribute($value)
    {
        $this->attributes['harga_per_item'] = $value;

        if (isset($this->attributes['jumlah_item'])) {
            $this->attributes['subtotal'] = $this->attributes['jumlah_item'] * $value;
        }
    }

    /**
     * Opsional: auto-hitung saat menyimpan model
     */
    protected static function booted()
    {
        static::saving(function ($detail) {
            if ($detail->jumlah_item && $detail->harga_per_item) {
                $detail->subtotal = $detail->jumlah_item * $detail->harga_per_item;
            }
        });
    }
}
