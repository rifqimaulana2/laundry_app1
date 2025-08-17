<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tagihan extends Model
{
    protected $table = 'tagihans';

    protected $fillable = [
        'order_id',
        'total_tagihan',
        'dp_dibayar',
        'sisa_tagihan',
        'status_pembayaran',
        'waktu_bayar_dp',
        'waktu_pelunasan',
        'metode_bayar',
        'pesanan_id',
    ];

    /**
     * RELASI: Tagihan milik satu pesanan
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    /**
     * Hitung ulang total_tagihan, sisa_tagihan, dan status otomatis
     * berdasarkan detail kiloan & satuan yang ada di DB.
     */
    public function calculateTotalTagihan(): void
    {
        $pesanan = $this->pesanan;

        $total = 0;
        if ($pesanan) {
            // ✅ pakai query langsung agar data selalu fresh
            $totalKiloan = $pesanan->kiloanDetails()->sum('subtotal') ?? 0;
            $totalSatuan = $pesanan->satuanDetails()->sum('subtotal') ?? 0;
            $total       = $totalKiloan + $totalSatuan;
        }

        $this->total_tagihan = $total;
        $this->sisa_tagihan  = max($total - ($this->dp_dibayar ?? 0), 0);

        // ✅ update status otomatis
        $this->status_pembayaran = $this->sisa_tagihan <= 0
            ? 'lunas'
            : 'belum lunas';

        $this->save();
    }
}
