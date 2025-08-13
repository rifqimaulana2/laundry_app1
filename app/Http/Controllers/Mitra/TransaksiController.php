<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Tagihan;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Halaman daftar tagihan untuk mitra
     */
    public function index()
    {
        $mitraId = Auth::user()->mitra->id;

        // Ambil semua tagihan yang terkait pesanan milik mitra ini
        $tagihans = Tagihan::whereHas('pesanan', function($q) use ($mitraId) {
                $q->where('mitra_id', $mitraId);
            })
            ->with([
                'pesanan.user.pelangganProfile', // relasi user -> pelangganProfile
                'pesanan.walkinCustomer'
            ])
            ->latest()
            ->get();

        return view('mitra.transaksi.index', compact('tagihans'));
    }

    /**
     * Halaman detail transaksi/pesanan
     */
    public function show($id)
    {
        $mitraId = Auth::user()->mitra->id;

        $pesanan = Pesanan::with([
                'user.pelangganProfile',
                'walkinCustomer',
                'tagihan',
                'riwayatTransaksi'
            ])
            ->where('mitra_id', $mitraId)
            ->findOrFail($id);

        return view('mitra.transaksi.show', compact('pesanan'));
    }

    /**
     * Form pelunasan tagihan
     */
    public function pelunasan($id)
    {
        $mitraId = Auth::user()->mitra->id;

        $pesanan = Pesanan::with('tagihan')
            ->where('mitra_id', $mitraId)
            ->findOrFail($id);

        if (!$pesanan->tagihan || $pesanan->tagihan->sisa_tagihan <= 0) {
            return redirect()->route('mitra.transaksi.index')
                ->with('error', 'Tagihan sudah lunas atau tidak ditemukan.');
        }

        return view('mitra.transaksi.pelunasan', compact('pesanan'));
    }

    /**
     * Proses pelunasan tagihan
     */
    public function prosesPelunasan(Request $request, $id)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode_bayar' => 'required|in:transfer,tunai'
        ]);

        $mitraId = Auth::user()->mitra->id;

        $pesanan = Pesanan::with('tagihan')
            ->where('mitra_id', $mitraId)
            ->findOrFail($id);

        $tagihan = $pesanan->tagihan;

        if (!$tagihan) {
            return back()->with('error', 'Tagihan tidak ditemukan.');
        }

        $jumlahBayar = min($request->jumlah_bayar, $tagihan->sisa_tagihan);

        // Update tagihan
        $tagihan->dp_dibayar += $jumlahBayar;
        $tagihan->sisa_tagihan -= $jumlahBayar;

        if ($tagihan->sisa_tagihan <= 0) {
            $tagihan->status_pembayaran = 'lunas';
            $tagihan->sisa_tagihan = 0;
        } else {
            $tagihan->status_pembayaran = 'dp_terbayar';
        }

        $tagihan->save();

        // Simpan riwayat transaksi
        RiwayatTransaksi::create([
            'pesanan_id' => $pesanan->id,
            'jumlah_transaksi' => $jumlahBayar,
            'metode_bayar' => $request->metode_bayar,
            'status_transaksi' => 'berhasil',
            'waktu_transaksi' => now(),
            'keterangan' => 'Pelunasan tagihan oleh mitra',
            'user_id' => Auth::id(),
            'mitra_id' => $mitraId,
        ]);

        return redirect()->route('mitra.transaksi.show', $pesanan->id)
            ->with('success', 'Pelunasan berhasil dicatat.');
    }

    /**
     * Store pembayaran tambahan dari halaman pesanan.show
     */
    public function store(Request $request, $tagihanId)
    {
        $request->validate([
            'jumlah_transaksi' => 'required|numeric|min:1',
            'metode_bayar' => 'required|in:transfer,tunai'
        ]);

        $mitraId = Auth::user()->mitra->id;

        $tagihan = Tagihan::with('pesanan')
            ->whereHas('pesanan', function($q) use ($mitraId) {
                $q->where('mitra_id', $mitraId);
            })
            ->findOrFail($tagihanId);

        $jumlahBayar = min($request->jumlah_transaksi, $tagihan->sisa_tagihan);

        $tagihan->dp_dibayar += $jumlahBayar;
        $tagihan->sisa_tagihan -= $jumlahBayar;

        if ($tagihan->sisa_tagihan <= 0) {
            $tagihan->status_pembayaran = 'lunas';
            $tagihan->sisa_tagihan = 0;
        } else {
            $tagihan->status_pembayaran = 'dp_terbayar';
        }

        $tagihan->save();

        RiwayatTransaksi::create([
            'pesanan_id' => $tagihan->pesanan->id,
            'jumlah_transaksi' => $jumlahBayar,
            'metode_bayar' => $request->metode_bayar,
            'status_transaksi' => 'berhasil',
            'waktu_transaksi' => now(),
            'keterangan' => 'Pembayaran tambahan dari halaman pesanan.show',
            'user_id' => Auth::id(),
            'mitra_id' => $mitraId,
        ]);

        return redirect()->route('mitra.pesanan.show', $tagihan->pesanan->id)
            ->with('success', 'Pembayaran berhasil ditambahkan.');
    }
}
