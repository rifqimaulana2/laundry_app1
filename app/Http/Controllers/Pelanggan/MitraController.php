<?php
namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Mitra;

class MitraController extends Controller
{
    // 1. Menampilkan semua mitra
    public function index()
    {
        $mitras = Mitra::all(); // Ambil semua mitra dari database
        return view('pelanggan.mitra.index', compact('mitras'));
    }

    // 2. Menampilkan detail mitra tertentu
    public function show($id)
    {
        // Ambil mitra berdasarkan ID, sekaligus relasi layanan
        $mitra = Mitra::with([
            'layananMitraKiloan.layananKiloan',
            'layananMitraSatuan.layananSatuan',
            'jamOperasionals'
        ])->find($id);

        // Jika tidak ditemukan, tampilkan pesan error
        if (!$mitra) {
            return view('pelanggan.mitra.show', ['error' => 'ID Mitra tidak ditemukan.']);
        }

        return view('pelanggan.mitra.show', compact('mitra'));
    }
}
