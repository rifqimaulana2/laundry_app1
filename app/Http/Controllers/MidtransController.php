<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // Log semua data untuk cek
        Log::info('Midtrans Callback: ', $request->all());

        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed === $request->signature_key) {

            // Cari pesanan berdasarkan order_id
            $pesanan = Pesanan::where('order_id', $request->order_id)->first();

            if ($pesanan) {
                // Jika status pembayaran sukses
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    // Update kolom DP
                    $pesanan->dp_bayar = $request->gross_amount;
                    $pesanan->status_pembayaran = 'DP Dibayar';
                    $pesanan->save();
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
