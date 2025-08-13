<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\PelangganProfile;
use Illuminate\Support\Facades\Auth;

class MitraController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pelangganProfile = PelangganProfile::where('user_id', $user->id)->first();
        $kecamatanFilter = request('kecamatan');

        // Ambil daftar kecamatan unik
        $kecamatanList = Mitra::distinct()->pluck('kecamatan')->toArray();
        $noKecamatan = false;

        // Base query untuk mitra yang disetujui
        $query = Mitra::where('status_approve', 'disetujui');

        if ($kecamatanFilter) {
            // Filter dari request
            $mitras = $query->where('kecamatan', $kecamatanFilter)
                            ->orderBy('nama_toko', 'asc')
                            ->get();

            if ($mitras->isEmpty()) {
                $noKecamatan = true;
                $mitras = $query->orderBy('nama_toko', 'asc')->get();
            }
        } elseif ($pelangganProfile && $pelangganProfile->alamat) {
            // Cek kecamatan berdasarkan alamat pelanggan
            $kecamatanPelanggan = collect($kecamatanList)->first(function ($kecamatan) use ($pelangganProfile) {
                return stripos($pelangganProfile->alamat, $kecamatan) !== false;
            });

            if ($kecamatanPelanggan) {
                $mitras = $query->where('kecamatan', $kecamatanPelanggan)
                                ->orderBy('nama_toko', 'asc')
                                ->get();
            } else {
                $noKecamatan = true;
                $mitras = $query->orderBy('nama_toko', 'asc')->get();
            }
        } else {
            $noKecamatan = true;
            $mitras = $query->orderBy('nama_toko', 'asc')->get();
        }

        return view('pelanggan.mitra.index', compact('mitras', 'noKecamatan', 'pelangganProfile', 'kecamatanList'));
    }

    public function show($id)
    {
        $mitra = Mitra::with([
            'layananMitraKiloan.layananKiloan',
            'layananMitraSatuan.layananSatuan',
            'jamOperasionals'
        ])->find($id);

        if (!$mitra) {
            return view('pelanggan.mitra.show', ['error' => 'ID Mitra tidak ditemukan.']);
        }

        // --- Ambil koordinat ---
        $lat = $mitra->latitude;
        $lng = $mitra->longitude;

        // Jika ada koordinat tertukar (contoh: longitude dimasukkan ke kolom latitude)
        if (abs($lat) > 90 && abs($lng) < 90) {
            [$lat, $lng] = [$lng, $lat]; // tukar posisi
        }

        // Pastikan latitude di Indonesia (sekitar -6 s/d -8)
        if ($lat > 0 && abs($lat) < 90) {
            $lat = -abs($lat);
        }

        // Siapkan query untuk Google Maps
        $mapsQuery = $mitra->formatted_address 
            ? urlencode($mitra->formatted_address) 
            : "{$lat},{$lng}";

        return view('pelanggan.mitra.show', compact('mitra', 'lat', 'lng', 'mapsQuery'));
    }
}
