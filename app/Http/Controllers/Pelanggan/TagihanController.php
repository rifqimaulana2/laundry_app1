<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function bayar(Tagihan $tagihan)
    {
        $this->authorizeUserOrFail($tagihan);

        if ($tagihan->status_pembayaran === 'lunas') {
            return redirect()->route('pelanggan.tagihan.show', $tagihan->id)
                ->with('error', 'Tagihan ini sudah lunas.');
        }

        $isDpWajib = $tagihan->pesanan->tipe_dp_wajib === 'Ya';
        $sudahBayarDp = $tagihan->dp_dibayar > 0;

        if (! $sudahBayarDp && $isDpWajib) {
            $jenisPembayaran = 'DP (50%)';
            $totalBayar = ceil($tagihan->total_tagihan * 0.5);
        } else {
            $jenisPembayaran = 'Pelunasan';
            $totalBayar = $tagihan->sisa_tagihan;
        }

        return view('pelanggan.tagihan.bayar', compact('tagihan', 'jenisPembayaran', 'totalBayar'));
    }

    public function prosesBayar(Request $request, Tagihan $tagihan)
    {
        $this->authorizeUserOrFail($tagihan);

        if ($tagihan->status_pembayaran === 'lunas') {
            return redirect()->route('pelanggan.tagihan.show', $tagihan->id)
                ->with('error', 'Tagihan ini sudah lunas.');
        }

        $isDpWajib = $tagihan->pesanan->tipe_dp_wajib === 'Ya';
        $sudahBayarDp = $tagihan->dp_dibayar > 0;

        if (! $sudahBayarDp && $isDpWajib) {
            // Bayar DP (50%)
            $bayar = ceil($tagihan->total_tagihan * 0.5);
            $tagihan->dp_dibayar = $bayar;
            $tagihan->sisa_tagihan = $tagihan->total_tagihan - $bayar;
            $tagihan->status_pembayaran = 'belum lunas';
        } else {
            // Bayar pelunasan
            $bayar = $tagihan->sisa_tagihan;
            $tagihan->sisa_tagihan = 0;
            $tagihan->status_pembayaran = 'lunas';
        }

        $tagihan->save();

        return redirect()->route('pelanggan.tagihan.show', $tagihan->id)
            ->with('success', "Pembayaran Rp " . number_format($bayar, 0, ',', '.') . " berhasil diproses.");
    }

    private function authorizeUserOrFail(Tagihan $tagihan): void
    {
        if (!$tagihan->pesanan || $tagihan->pesanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke tagihan ini.');
        }
    }
}
