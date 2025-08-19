<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesananDetailKiloan extends Model
{
    protected $table = 'pesanan_detail_kiloan';

    protected $fillable = [
        'pesanan_id',
        'layanan_mitra_kiloan_id',
        'berat_sementara',
        'berat_final',
        'harga_per_kg',
        'subtotal',
    ];

    /**
     * RELASI: Ke tabel pesanan
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * RELASI: Ke layanan mitra kiloan
     */
    public function layananMitraKiloan(): BelongsTo
    {
        return $this->belongsTo(LayananMitraKiloan::class);
    }

    /**
     * Setter otomatis saat berat_final diisi
     */
    public function setBeratFinalAttribute($value)
    {
        $this->attributes['berat_final'] = $value;

        if (isset($this->attributes['harga_per_kg'])) {
            $this->attributes['subtotal'] = $value * $this->attributes['harga_per_kg'];
        }
    }

    /**
     * Setter otomatis saat harga_per_kg diisi
     */
    public function setHargaPerKgAttribute($value)
    {
        $this->attributes['harga_per_kg'] = $value;

        if (isset($this->attributes['berat_final'])) {
            $this->attributes['subtotal'] = $this->attributes['berat_final'] * $value;
        }
    }

    /**
     * Opsional: Auto hitung ulang saat model disimpan
     */
    protected static function booted()
    {
        static::saving(function ($detail) {
            if ($detail->berat_final && $detail->harga_per_kg) {
                $detail->subtotal = $detail->berat_final * $detail->harga_per_kg;
            }
        });
    }
}