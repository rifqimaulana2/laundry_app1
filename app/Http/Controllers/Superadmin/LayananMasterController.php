<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisLayanan;
use App\Models\LayananKiloan;
use App\Models\LayananSatuan;

class LayananMasterController extends Controller
{
    /**
     * Menampilkan semua layanan dalam satu halaman.
     */
    public function index()
    {
        $jenisLayanans = JenisLayanan::all();
        $layananKiloans = LayananKiloan::with('jenisLayanan')->get();
        $layananSatuans = LayananSatuan::with('jenisLayanan')->get();

        return view('superadmin.layanan_master.index', compact('jenisLayanans', 'layananKiloans', 'layananSatuans'));
    }

    // --- LOGIKA UNTUK JENIS LAYANAN ---

    /**
     * Menampilkan formulir untuk membuat Jenis Layanan baru.
     */
    public function createJenis()
    {
        return view('superadmin.layanan_master.jenis.create');
    }

    /**
     * Menyimpan Jenis Layanan baru ke database.
     */
    public function storeJenis(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
        ]);

        JenisLayanan::create($request->all());

        return redirect()->route('superadmin.layanan-master.index')->with('success', 'Jenis Layanan berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir untuk mengedit Jenis Layanan.
     */
    public function editJenis(JenisLayanan $jenisLayanan)
    {
        return view('superadmin.layanan_master.jenis.edit', compact('jenisLayanan'));
    }

    /**
     * Memperbarui Jenis Layanan yang sudah ada.
     */
    public function updateJenis(Request $request, JenisLayanan $jenisLayanan)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
        ]);

        $jenisLayanan->update($request->all());

        return redirect()->route('superadmin.layanan-master.index')->with('success', 'Jenis Layanan berhasil diperbarui!');
    }

    /**
     * Menghapus Jenis Layanan dari database.
     */
    public function destroyJenis(JenisLayanan $jenisLayanan)
    {
        $jenisLayanan->delete();

        return redirect()->route('superadmin.layanan-master.index')->with('success', 'Jenis Layanan berhasil dihapus!');
    }


    // --- LOGIKA UNTUK LAYANAN KILOAN ---

    /**
     * Menampilkan formulir untuk membuat Layanan Kiloan baru.
     */
    public function createKiloan()
    {
        $jenisLayanans = JenisLayanan::all();
        return view('superadmin.layanan_master.kiloan.create', compact('jenisLayanans'));
    }

    /**
     * Menyimpan Layanan Kiloan baru ke database.
     */
    public function storeKiloan(Request $request)
    {
        $request->validate([
            'jenis_layanan_id' => 'required|exists:jenis_layanan,id',
            'nama_paket' => 'required|string|max:255',
        ]);

        LayananKiloan::create($request->all());

        return redirect()->route('superadmin.layanan-master.index')->with('success', 'Layanan Kiloan berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir untuk mengedit Layanan Kiloan.
     */
    public function editKiloan(LayananKiloan $layananKiloan)
    {
        $jenisLayanans = JenisLayanan::all();
        return view('superadmin.layanan_master.kiloan.edit', compact('layananKiloan', 'jenisLayanans'));
    }

    /**
     * Memperbarui Layanan Kiloan yang sudah ada.
     */
    public function updateKiloan(Request $request, LayananKiloan $layananKiloan)
    {
        $request->validate([
            'jenis_layanan_id' => 'required|exists:jenis_layanan,id',
            'nama_paket' => 'required|string|max:255',
        ]);

        $layananKiloan->update($request->all());

        return redirect()->route('superadmin.layanan-master.index')->with('success', 'Layanan Kiloan berhasil diperbarui!');
    }

    /**
     * Menghapus Layanan Kiloan dari database.
     */
    public function destroyKiloan(LayananKiloan $layananKiloan)
    {
        $layananKiloan->delete();

        return redirect()->route('superadmin.layanan-master.index')->with('success', 'Layanan Kiloan berhasil dihapus!');
    }


    // --- LOGIKA UNTUK LAYANAN SATUAN ---

    /**
     * Menampilkan formulir untuk membuat Layanan Satuan baru.
     */
    public function createSatuan()
    {
        $jenisLayanans = JenisLayanan::all();
        return view('superadmin.layanan_master.satuan.create', compact('jenisLayanans'));
    }

    /**
     * Menyimpan Layanan Satuan baru ke database.
     */
    public function storeSatuan(Request $request)
    {
        $request->validate([
            'jenis_layanan_id' => 'required|exists:jenis_layanan,id',
            'nama_layanan' => 'required|string|max:255',
        ]);

        LayananSatuan::create($request->all());

        return redirect()->route('superadmin.layanan-master.index')->with('success', 'Layanan Satuan berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir untuk mengedit Layanan Satuan.
     */
    public function editSatuan(LayananSatuan $layananSatuan)
    {
        $jenisLayanans = JenisLayanan::all();
        return view('superadmin.layanan_master.satuan.edit', compact('layananSatuan', 'jenisLayanans'));
    }

    /**
     * Memperbarui Layanan Satuan yang sudah ada.
     */
    public function updateSatuan(Request $request, LayananSatuan $layananSatuan)
    {
        $request->validate([
            'jenis_layanan_id' => 'required|exists:jenis_layanan,id',
            'nama_layanan' => 'required|string|max:255',
        ]);

        $layananSatuan->update($request->all());

        return redirect()->route('superadmin.layanan-master.index')->with('success', 'Layanan Satuan berhasil diperbarui!');
    }

    /**
     * Menghapus Layanan Satuan dari database.
     */
    public function destroySatuan(LayananSatuan $layananSatuan)
    {
        $layananSatuan->delete();

        return redirect()->route('superadmin.layanan-master.index')->with('success', 'Layanan Satuan berhasil dihapus!');
    }
}