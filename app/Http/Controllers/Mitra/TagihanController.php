<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\TrackingStatus;
use App\Models\StatusMaster;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index()
    {
        $mitraId = Auth::user()->mitra->id;

        $tagihans = Tagihan::whereHas('pesanan', function($q) use ($mitraId) {
            $q->where('mitra_id', $mitraId);
        })->with(['pesanan.user', 'pesanan.walkinCustomer'])->orderByDesc('created_at')->get();

        return view('mitra.tagihan.index', compact('tagihans'));
    }

    public function show($id)
    {
        $tagihan = Tagihan::with([
            'pesanan.user',
            'pesanan.walkinCustomer',
            'pesanan.kiloanDetails.layananMitraKiloan.layananKiloan',
            'pesanan.satuanDetails.layananMitraSatuan.layananSatuan'
        ])->findOrFail($id);

        return view('mitra.tagihan.show', compact('tagihan'));
    }

    public function verifikasiLunas($id)
    {
        $tagihan = Tagihan::with('pesanan')->findOrFail($id);
        $tagihan->status_pembayaran = 'lunas';
        $tagihan->sisa_tagihan = 0;
        $tagihan->save();

        // Tracking status pembayaran
        $statusLunas = StatusMaster::where('nama_status', 'pembayaran_lunas')->first();
        TrackingStatus::create([
            'pesanan_id'        => $tagihan->pesanan->id,
            'status_master_id'  => $statusLunas->id ?? 1,
            'waktu'             => now(),
            'user_id'           => auth()->id(),
            'mitra_id'          => auth()->user()->mitra->id,
            'pesan'             => 'Pembayaran tagihan dikonfirmasi lunas oleh mitra'
        ]);

        return redirect()->route('mitra.tagihan.index')->with('success', 'Tagihan berhasil ditandai lunas.');
    }
}
