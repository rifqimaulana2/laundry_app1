<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mitra;
use App\Models\Toko;
use App\Models\DataDiri;
use App\Models\Pesanan;
use App\Models\User;

class PelangganController extends Controller
{
    // Form Data Diri
    public function formDataDiri()
    {
        $data = DataDiri::where('user_id', Auth::id())->first();
        return view('pelanggan.data-diri', compact('data'));
    }

    // Simpan Data Diri
    public function simpanDataDiri(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'no_telepon' => 'required|string',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        DataDiri::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only(['nama_lengkap', 'no_telepon', 'alamat', 'latitude', 'longitude'])
        );

        return redirect()->route('pelanggan.profil')->with('success', 'Data diri berhasil disimpan.');
    }

    // Menampilkan halaman profil
    public function profil()
    {
        $data = DataDiri::where('user_id', Auth::id())->first();
        return view('pelanggan.profil', compact('data'));
    }

    // Update profil (data diri)
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'no_telepon' => 'required|string',
            'alamat' => 'required|string',
        ]);

        DataDiri::where('user_id', Auth::id())->update($request->only(['nama_lengkap', 'no_telepon', 'alamat']));

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    // Daftar Mitra Berdasarkan Lokasi Pelanggan
    public function indexMitra()
    {
        $dataDiri = DataDiri::where('user_id', Auth::id())->first();

        if (!$dataDiri) {
            return redirect()->route('pelanggan.data-diri')->with('warning', 'Harap lengkapi data diri terlebih dahulu.');
        }

        $mitras = Mitra::all()->map(function ($mitra) use ($dataDiri) {
            $jarak = sqrt(
                pow($mitra->latitude - $dataDiri->latitude, 2) +
                pow($mitra->longitude - $dataDiri->longitude, 2)
            );
            $mitra->jarak = $jarak;
            return $mitra;
        })->sortBy('jarak');

        return view('pelanggan.mitra', compact('mitras'));
    }

    public function layananMitra($slug)
    {
        $toko = Toko::where('slug', $slug)->with('layanans')->firstOrFail();
        return view('pelanggan.layanan.kemuning', compact('toko'));
    }

    public function pesanMitra(Request $request, $slug)
    {
        return redirect()->back()->with('success', 'Pesanan berhasil dikirim.');
    }

    public function trackingMitra($id)
    {
        $pesanan = Pesanan::find($id);
        return view('pelanggan.tracking', compact('pesanan'));
    }

    public function konfirmasiMitra($id)
    {
        $pesanan = Pesanan::find($id);
        return view('pelanggan.konfirmasi', compact('pesanan'));
    }

    public function updateKonfirmasiMitra(Request $request, $id)
    {
        return redirect()->route('pelanggan.konfirmasi', $id)->with('success', 'Konfirmasi berhasil diperbarui.');
    }

    public function riwayatMitra()
    {
    $user = auth()->user() ?? abort(403, 'Unauthorized');


        $transactions = Pesanan::with('toko')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('pelanggan.riwayat', compact('transactions'));
    }

    public function showToko($id)
    {
        $toko = Toko::findOrFail($id);
        return view('pelanggan.layanan.kemuning', compact('toko'));
    }

    public function showLayananStatis($nama)
    {
        return view("pelanggan.layanan.{$nama}");
    }

    public function storeLayananStatis(Request $request, $toko)
    {
        // Validasi dan simpan layanan statis
    }
}
