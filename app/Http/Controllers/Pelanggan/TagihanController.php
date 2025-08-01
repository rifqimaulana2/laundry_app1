<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;

class TagihanController extends Controller
{
    /**
     * Menampilkan semua tagihan milik pelanggan.
     */
    public function index()
    {
        $tagihans = Tagihan::whereHas('pesanan', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('pesanan.mitra')->get();

        Log::info('Fetching tagihan for user ID: ' . Auth::id(), [
            'count' => $tagihans->count(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        return view('pelanggan.tagihan.index', compact('tagihans'));
    }

    /**
     * Menampilkan detail satu tagihan.
     */
    public function show(Tagihan $tagihan)
    {
        if (!$this->authorizeUser($tagihan)) {
            Log::warning('Unauthorized access to tagihan ID: ' . $tagihan->id, [
                'user_id' => Auth::id(),
                'tagihan_user_id' => optional($tagihan->pesanan)->user_id,
                'timestamp' => now()->toDateTimeString(),
            ]);
            abort(403, 'Unauthorized');
        }

        $tagihan->load('pesanan.mitra');
        Log::info('Showing tagihan ID: ' . $tagihan->id, [
            'user_id' => Auth::id(),
            'timestamp' => now()->toDateTimeString(),
        ]);
        return view('pelanggan.tagihan.show', compact('tagihan'));
    }

    /**
     * Menampilkan halaman pembayaran Midtrans.
     */
    public function bayar(Tagihan $tagihan)
    {
        try {
            if (!$this->authorizeUser($tagihan)) {
                Log::warning('Unauthorized access to bayar tagihan ID: ' . $tagihan->id, [
                    'user_id' => Auth::id(),
                    'tagihan_user_id' => optional($tagihan->pesanan)->user_id,
                    'timestamp' => now()->toDateTimeString(),
                ]);
                abort(403, 'Unauthorized');
            }

            if ($tagihan->status_pembayaran === 'lunas') {
                Log::info('Tagihan ID: ' . $tagihan->id . ' already paid', [
                    'user_id' => Auth::id(),
                    'timestamp' => now()->toDateTimeString(),
                ]);
                return redirect()->route('pelanggan.tagihan.show', $tagihan->id)
                    ->with('error', 'Tagihan sudah lunas.');
            }

            $grossAmount = $tagihan->dp_dibayar > 0 ? $tagihan->sisa_tagihan : $tagihan->total_tagihan;

            if ($grossAmount <= 0) {
                Log::warning('Invalid gross amount for tagihan ID: ' . $tagihan->id, [
                    'gross_amount' => $grossAmount,
                    'dp_dibayar' => $tagihan->dp_dibayar,
                    'total_tagihan' => $tagihan->total_tagihan,
                    'sisa_tagihan' => $tagihan->sisa_tagihan,
                    'timestamp' => now()->toDateTimeString(),
                ]);
                return redirect()->route('pelanggan.tagihan.show', $tagihan->id)
                    ->with('error', 'Jumlah tagihan tidak valid.');
            }

            // Inisialisasi Midtrans
            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction', false);
            Config::$isSanitized = config('midtrans.isSanitized', true);
            Config::$is3ds = config('midtrans.is3ds', true);

            $params = [
                'transaction_details' => [
                    'order_id' => 'TAGIHAN-' . $tagihan->id . '-' . now()->timestamp,
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

            Log::info('Generating Midtrans Snap Token for tagihan ID: ' . $tagihan->id, [
                'params' => $params,
                'timestamp' => now()->toDateTimeString(),
            ]);

            $snapToken = Snap::getSnapToken($params);

            return view('pelanggan.tagihan.bayar', compact('snapToken', 'tagihan'));
        } catch (\Exception $e) {
            Log::error('Error generating Midtrans Snap Token for tagihan ID: ' . $tagihan->id, [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'params' => $params ?? 'N/A',
                'timestamp' => now()->toDateTimeString(),
            ]);
            return redirect()->route('pelanggan.tagihan.show', $tagihan->id)
                ->with('error', 'Gagal memuat halaman pembayaran. Silakan coba lagi atau hubungi dukungan.');
        }
    }

    /**
     * Callback dari Midtrans setelah transaksi.
     */
    public function midtransCallback(Request $request)
    {
        try {
            $serverKey = config('midtrans.serverKey');
            if (!$serverKey) {
                Log::critical('Midtrans serverKey not configured', ['request' => $request->all()]);
                return response()->json(['message' => 'Server configuration error'], 500);
            }

            $expectedSignature = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            if ($request->signature_key !== $expectedSignature) {
                Log::warning('Invalid Midtrans signature', [
                    'order_id' => $request->order_id,
                    'signature_key' => $request->signature_key,
                    'expected_signature' => $expectedSignature,
                    'timestamp' => now()->toDateTimeString(),
                ]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $tagihanId = explode('-', $request->order_id)[1] ?? null;
            if (!$tagihanId) {
                Log::warning('Invalid order ID format', [
                    'order_id' => $request->order_id,
                    'timestamp' => now()->toDateTimeString(),
                ]);
                return response()->json(['message' => 'Invalid order ID'], 400);
            }

            $tagihan = Tagihan::find($tagihanId);
            if (!$tagihan) {
                Log::warning('Tagihan not found', [
                    'tagihan_id' => $tagihanId,
                    'timestamp' => now()->toDateTimeString(),
                ]);
                return response()->json(['message' => 'Tagihan not found'], 404);
            }

            if ($request->transaction_status === 'settlement') {
                $tagihan->status_pembayaran = 'lunas';
                $tagihan->sisa_tagihan = 0;
                $tagihan->waktu_pelunasan = now();
                $tagihan->save();

                Log::info('Midtrans settlement processed for tagihan ID: ' . $tagihan->id, [
                    'transaction_status' => $request->transaction_status,
                    'order_id' => $request->order_id,
                    'timestamp' => now()->toDateTimeString(),
                ]);
            } elseif ($request->transaction_status === 'pending') {
                $tagihan->status_pembayaran = 'menunggu';
                $tagihan->save();

                Log::info('Midtrans pending processed for tagihan ID: ' . $tagihan->id, [
                    'transaction_status' => $request->transaction_status,
                    'order_id' => $request->order_id,
                    'timestamp' => now()->toDateTimeString(),
                ]);
            }

            return response()->json(['message' => 'Callback processed'], 200);
        } catch (\Exception $e) {
            Log::error('Error processing Midtrans callback', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'timestamp' => now()->toDateTimeString(),
            ]);
            return response()->json(['message' => 'Error processing callback'], 500);
        }
    }

    /**
     * Helper untuk memastikan tagihan milik user yang login.
     */
    private function authorizeUser(Tagihan $tagihan): bool
    {
        // Hanya izinkan jika pesanan terkait dengan user yang login
        $isAuthorized = $tagihan->pesanan && $tagihan->pesanan->user_id === Auth::id();
        if (!$isAuthorized) {
            Log::warning('Authorization failed for tagihan ID: ' . $tagihan->id, [
                'user_id' => Auth::id(),
                'tagihan_user_id' => optional($tagihan->pesanan)->user_id,
                'timestamp' => now()->toDateTimeString(),
            ]);
        }
        return $isAuthorized;
    }
}