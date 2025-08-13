<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::whereHas('pesanan', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('pesanan.mitra')->get();

        return view('pelanggan.tagihan.index', compact('tagihans'));
    }

    public function show(Tagihan $tagihan)
    {
        $this->authorizeUserOrFail($tagihan);
        $tagihan->load(['pesanan.mitra', 'pesanan.riwayatTransaksi']);
        return view('pelanggan.tagihan.show', compact('tagihan'));
    }

    private function cancelPreviousTransaction(string $orderId): void
    {
        try {
            $status = Transaction::status($orderId);
            if (in_array(strtolower($status->transaction_status), ['pending', 'capture', 'challenge'])) {
                Transaction::cancel($orderId);
                Log::info("Transaksi lama {$orderId} dibatalkan.");
            } else {
                Log::info("Transaksi {$orderId} tidak dapat dibatalkan karena status: {$status->transaction_status}");
            }
        } catch (\Exception $e) {
            Log::warning("Gagal membatalkan transaksi {$orderId}: " . $e->getMessage());
        }
    }

    public function bayar(Tagihan $tagihan)
    {
        $this->authorizeUserOrFail($tagihan);

        if ($tagihan->status_pembayaran === 'lunas') {
            return redirect()->route('pelanggan.tagihan.show', $tagihan->id)
                ->with('error', 'Tagihan ini sudah lunas.');
        }

        $grossAmount = $tagihan->dp_dibayar > 0
            ? $tagihan->sisa_tagihan
            : ceil($tagihan->total_tagihan * 0.5);

        if ($grossAmount <= 0) {
            return redirect()->route('pelanggan.tagihan.show', $tagihan->id)
                ->with('error', 'Jumlah tagihan tidak valid.');
        }

        $orderIdPrefix = $tagihan->dp_dibayar > 0 ? 'PELUNASAN' : 'DP';
        if (!empty($tagihan->order_id) && strpos($tagihan->order_id, 'TEMP-') !== 0) {
            $this->cancelPreviousTransaction($tagihan->order_id);
        }

        $orderId = "{$orderIdPrefix}-{$tagihan->pesanan_id}-{$tagihan->id}-" . time() . '-' . uniqid();

        $tagihan->update([
            'order_id' => $orderId,
            'metode_bayar' => 'midtrans'
        ]);

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone ?? '',
            ],
            'callbacks' => [
                'finish' => route('pelanggan.tagihan.show', $tagihan->id),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            Log::info("Snap token berhasil dibuat untuk order_id {$orderId}");
            return view('pelanggan.tagihan.bayar', compact('snapToken', 'tagihan'));
        } catch (\Exception $e) {
            Log::error("Gagal membuat Snap Token untuk order_id {$orderId}: " . $e->getMessage());
            return redirect()->route('pelanggan.tagihan.show', $tagihan->id)
                ->with('error', 'Gagal membuat token pembayaran. Silakan coba lagi.');
        }
    }

    private function authorizeUserOrFail(Tagihan $tagihan): void
    {
        if (!$tagihan->pesanan || $tagihan->pesanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke tagihan ini.');
        }
    }
}