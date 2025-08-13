<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Tagihan;
use App\Models\RiwayatTransaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Midtrans Callback diterima', $request->all());

        try {
            $notif = new Notification();
            $orderId = $notif->order_id ?? null;
            $transactionStatus = strtolower($notif->transaction_status ?? '');
            $paymentType = $notif->payment_type ?? 'midtrans';
            $grossAmount = isset($notif->gross_amount) ? (int) round($notif->gross_amount) : 0;
            $transactionTime = isset($notif->transaction_time) ? Carbon::parse($notif->transaction_time) : Carbon::now();

            if (!$orderId) {
                Log::warning("Midtrans Callback: order_id kosong");
                return response()->json(['message' => 'Order ID tidak ditemukan'], 400);
            }

            // Cari tagihan berdasarkan order_id
            $tagihan = Tagihan::where('order_id', $orderId)->first();

            if (!$tagihan) {
                // Fallback: coba ambil dari format order_id
                $parts = explode('-', $orderId);
                foreach ($parts as $part) {
                    if (is_numeric($part)) {
                        $tagihan = Tagihan::where('pesanan_id', $part)->orWhere('id', $part)->first();
                        if ($tagihan) {
                            $tagihan->update(['order_id' => $orderId]);
                            break;
                        }
                    }
                }
            }

            if (!$tagihan) {
                Log::warning("Midtrans Callback: Tagihan tidak ditemukan untuk order_id {$orderId}");
                return response()->json(['message' => 'Tagihan tidak ditemukan'], 404);
            }

            $statusSukses = ['capture', 'settlement', 'paid', 'success'];
            $statusGagal = ['cancel', 'expire', 'deny', 'failure'];

            if (in_array($transactionStatus, $statusSukses)) {
                $jenisPembayaran = stripos($orderId, 'PELUNASAN-') === 0 ? 'pelunasan' : 'dp';

                // Cegah pencatatan ganda
                $sudahAda = RiwayatTransaksi::where('pesanan_id', $tagihan->pesanan_id)
                    ->where('nominal', $grossAmount)
                    ->where('jenis_transaksi', $jenisPembayaran)
                    ->exists();

                if (!$sudahAda) {
                    // Hitung pembayaran baru
                    if ($jenisPembayaran === 'dp') {
                        $totalBayar = $grossAmount; // DP awal
                    } else {
                        $totalBayar = $tagihan->dp_dibayar + $grossAmount; // Tambah pelunasan
                    }

                    $sisaBaru = max(0, $tagihan->total_tagihan - $totalBayar);

                    // Update tagihan
                    $tagihan->update([
                        'dp_dibayar' => $totalBayar,
                        'sisa_tagihan' => $sisaBaru,
                        'status_pembayaran' => $sisaBaru <= 0 ? 'lunas' : ($jenisPembayaran === 'dp' ? 'dp_terbayar' : 'belum lunas'),
                        'waktu_bayar_dp' => $jenisPembayaran === 'dp' ? $transactionTime : $tagihan->waktu_bayar_dp,
                        'waktu_pelunasan' => $sisaBaru <= 0 ? $transactionTime : $tagihan->waktu_pelunasan,
                        'metode_bayar' => $paymentType,
                    ]);

                    // Simpan riwayat transaksi
                    RiwayatTransaksi::create([
                        'pesanan_id' => $tagihan->pesanan_id,
                        'user_id' => $tagihan->pesanan->user_id ?? null,
                        'nominal' => $grossAmount,
                        'jenis_transaksi' => $jenisPembayaran,
                        'metode_bayar' => $paymentType,
                        'waktu' => $transactionTime,
                    ]);

                    Log::info("Pembayaran {$jenisPembayaran} untuk order_id {$orderId} berhasil dicatat.");
                } else {
                    Log::info("Pembayaran untuk order_id {$orderId} sudah pernah dicatat, di-skip.");
                }
            } elseif (in_array($transactionStatus, $statusGagal)) {
                $tagihan->update(['status_pembayaran' => 'dibatalkan']);
                Log::warning("Transaksi {$orderId} dibatalkan, status: {$transactionStatus}");
            } else {
                Log::warning("Transaksi {$orderId} dalam status: {$transactionStatus}");
            }

            return response()->json(['message' => 'Notifikasi diproses'], 200);
        } catch (\Exception $e) {
            Log::error("Midtrans Callback Error: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'Error memproses callback', 'error' => $e->getMessage()], 500);
        }
    }
}
