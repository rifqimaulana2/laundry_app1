<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tagihan extends Model
{
    protected $table = 'tagihans';

    protected $fillable = [
        'pesanan_id',
        'total_tagihan',
        'dp_dibayar',
        'sisa_tagihan',
        'metode_bayar',
        'status_pembayaran',
        'jatuh_tempo_pelunasan',
        'waktu_bayar_dp',
        'waktu_pelunasan',
    ];

    /**
     * RELASI: Tagihan milik satu pesanan
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * Hitung total_tagihan, sisa_tagihan, dan status otomatis dari detail pesanan
     */
    public function calculateTotalTagihan(): void
    {
        $pesanan = $this->pesanan;

        $total = 0;
        if ($pesanan) {
            $total += $pesanan->pesananDetailKiloan->sum('subtotal') ?? 0;
            $total += $pesanan->pesananDetailSatuan->sum('subtotal') ?? 0;
        }

        $this->total_tagihan = $total;
        $this->sisa_tagihan = $total - ($this->dp_dibayar ?? 0);

        // Otomatis tentukan status pembayaran
        if ($this->sisa_tagihan <= 0) {
            $this->status_pembayaran = 'lunas';
        } else {
            $this->status_pembayaran = 'belum lunas';
        }

        $this->save();
    }
}
