<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\RiwayatTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    public function index()
    {
        $mitraId = auth()->user()->mitra->id;
        $tagihans = Tagihan::whereHas('pesanan', fn($q) => $q->where('mitra_id', $mitraId))
            ->with(['pesanan.user', 'pesanan.walkinCustomer'])
            ->latest()
            ->get();

        return view('mitra.tagihan.index', compact('tagihans'));
    }

    public function show(Tagihan $tagihan)
    {
        $this->authorize('view', $tagihan->pesanan);
        $tagihan->load([
            'pesanan.user',
            'pesanan.walkinCustomer',
            'pesanan.pesananDetailKiloan.layananMitraKiloan.layananKiloan',
            'pesanan.pesananDetailSatuan.layananMitraSatuan.layananSatuan'
        ]);

        return view('mitra.tagihan.show', compact('tagihan'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $this->authorize('update', $tagihan->pesanan);
        $request->validate([
            'status_pembayaran' => 'required|in:belum lunas,dp_terbayar,lunas',
            'dp_dibayar' => 'required_if:status_pembayaran,dp_terbayar|numeric|min:0',
            'metode_bayar' => 'required|in:cash,transfer',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'status_pembayaran' => $request->status_pembayaran,
                'metode_bayar' => $request->metode_bayar,
                'waktu_pelunasan' => $request->status_pembayaran === 'lunas' ? now() : null,
                'dp_dibayar' => $request->status_pembayaran === 'dp_terbayar' ? $request->dp_dibayar : $tagihan->dp_dibayar,
                'sisa_tagihan' => $tagihan->total_tagihan - ($request->status_pembayaran === 'dp_terbayar' ? $request->dp_dibayar : $tagihan->dp_dibayar),
            ];

            $tagihan->update($data);

            if ($request->status_pembayaran === 'dp_terbayar' || $request->status_pembayaran === 'lunas') {
                RiwayatTransaksi::create([
                    'pesanan_id' => $tagihan->pesanan_id,
                    'user_id' => $tagihan->pesanan->user_id,
                    'nominal' => $request->status_pembayaran === 'dp_terbayar' ? $request->dp_dibayar : $tagihan->total_tagihan,
                    'jenis_transaksi' => $request->status_pembayaran === 'dp_terbayar' ? 'dp' : 'pelunasan',
                    'metode_bayar' => $request->metode_bayar,
                    'waktu' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('mitra.tagihan.index')->with('success', 'Status tagihan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui tagihan: ' . $e->getMessage()]);
        }
    }
}