<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index()
    {
        $mitraId = auth()->user()->mitra->id;
        $tagihans = Tagihan::whereHas('pesanan', function ($query) use ($mitraId) {
            $query->where('mitra_id', $mitraId);
        })->with(['pesanan.user', 'pesanan.walkinCustomer'])->get();
        return view('mitra.tagihan.index', compact('tagihans'));
    }

    public function show(Tagihan $tagihan)
    {
        $this->authorize('view', $tagihan);
        $tagihan->load(['pesanan.user', 'pesanan.walkinCustomer', 'pesanan.pesananDetailKiloan', 'pesanan.pesananDetailSatuan']);
        return view('mitra.tagihan.show', compact('tagihan'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $this->authorize('update', $tagihan);
        $request->validate([
            'status_pembayaran' => 'required|in:belum lunas,lunas',
        ]);

        $tagihan->update([
            'status_pembayaran' => $request->status_pembayaran,
            'tanggal_pelunasan' => $request->status_pembayaran === 'lunas' ? now() : null,
        ]);

        return redirect()->route('mitra.tagihan.index')->with('success', 'Status tagihan berhasil diperbarui.');
    }
}