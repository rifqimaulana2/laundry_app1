<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatTransaksi;

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
     */
    public function calculateTotalTagihan(): void
    {
        $pesanan = $this->pesanan;

        $total = 0;
        if ($pesanan) {
            $totalKiloan = $pesanan->kiloanDetails()->sum('subtotal') ?? 0;
            $totalSatuan = $pesanan->satuanDetails()->sum('subtotal') ?? 0;
            $total       = $totalKiloan + $totalSatuan;
        }

        $this->total_tagihan = $total;
        $this->sisa_tagihan  = max($total - ($this->dp_dibayar ?? 0), 0);

        $this->status_pembayaran = $this->sisa_tagihan <= 0
            ? 'lunas'
            : 'belum lunas';

        $this->save();
    }

    /**
     * Tambah pembayaran (DP atau pelunasan) + catat ke riwayat_transaksi
     */
    public function tambahPembayaran(
        int $jumlah,
        string $jenis = 'dp',
        string $metode = 'transfer',
        ?string $keterangan = null
    ): void {
        $this->dp_dibayar += $jumlah;
        $this->sisa_tagihan = max($this->total_tagihan - $this->dp_dibayar, 0);

        // Jika ini pembayaran pertama (DP)
        if (is_null($this->waktu_bayar_dp) && strtolower($jenis) === 'dp') {
            $this->waktu_bayar_dp = now();
        }

        // Jika sudah lunas
        if ($this->sisa_tagihan <= 0) {
            $this->status_pembayaran = 'lunas';
            $this->waktu_pelunasan   = now();
        }

        $this->save();

        // Catat ke tabel riwayat_transaksi
        RiwayatTransaksi::create([
            'pesanan_id'      => $this->pesanan_id,
            'user_id'         => Auth::id(),
            'nominal'         => $jumlah,
            'jenis_transaksi' => strtolower($jenis), // dp / pelunasan
            'metode_bayar'    => strtolower($metode),
            'keterangan'      => $keterangan,
            'waktu'           => now(),
        ]);
    }

    /**
     * Recalculate total dari detail kiloan/satuan
     * khusus saat mitra konfirmasi timbangan real
     */
    public function recalculateFromDetails(): void
    {
        $pesanan = $this->pesanan;

        $total = 0;
        if ($pesanan) {
            // hitung ulang kiloan (berat_final kalau ada)
            $totalKiloan = $pesanan->kiloanDetails()
                ->selectRaw('SUM(CASE 
                    WHEN berat_final IS NOT NULL 
                    THEN berat_final * harga_per_kg 
                    ELSE berat_sementara * harga_per_kg 
                END) as total')
                ->value('total') ?? 0;

            // hitung ulang satuan
            $totalSatuan = $pesanan->satuanDetails()->sum('subtotal') ?? 0;

            $total = $totalKiloan + $totalSatuan;
        }

        $this->total_tagihan = $total;
        $this->sisa_tagihan  = max($total - ($this->dp_dibayar ?? 0), 0);

        $this->status_pembayaran = $this->sisa_tagihan <= 0
            ? 'lunas'
            : 'belum lunas';

        $this->save();
    }
}
