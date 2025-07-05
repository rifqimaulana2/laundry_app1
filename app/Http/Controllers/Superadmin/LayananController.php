<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\JenisLayanan;
use App\Models\LayananKiloan;
use App\Models\LayananSatuan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    // 1. Menampilkan semua layanan
    public function index()
    {
        $jenisLayanan = JenisLayanan::all();
        $layananKiloan = LayananKiloan::all();
        $layananSatuan = LayananSatuan::all();

        return view('superadmin.layanan.index', compact('jenisLayanan', 'layananKiloan', 'layananSatuan'));
    }

    // 2. Menyimpan layanan baru berdasarkan tipe
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:jenis_layanan,kiloan,satuan',
            'nama_layanan' => 'required_if:type,jenis_layanan,satuan|string|max:100',
            'nama_paket' => 'required_if:type,kiloan|string|max:100',
            'durasi_hari' => 'required_if:type,kiloan|integer|min:1',
        ]);

        if ($validated['type'] === 'jenis_layanan') {
            JenisLayanan::create(['nama_layanan' => $validated['nama_layanan']]);
        } elseif ($validated['type'] === 'kiloan') {
            LayananKiloan::create([
                'nama_paket' => $validated['nama_paket'],
                'durasi_hari' => $validated['durasi_hari'],
            ]);
        } elseif ($validated['type'] === 'satuan') {
            LayananSatuan::create(['nama_layanan' => $validated['nama_layanan']]);
        }

        return redirect()->route('superadmin.layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    // 3. Mengupdate layanan berdasarkan tipe dan ID
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|in:jenis_layanan,kiloan,satuan',
            'nama_layanan' => 'required_if:type,jenis_layanan,satuan|string|max:100',
            'nama_paket' => 'required_if:type,kiloan|string|max:100',
            'durasi_hari' => 'required_if:type,kiloan|integer|min:1',
        ]);

        if ($validated['type'] === 'jenis_layanan') {
            $layanan = JenisLayanan::findOrFail($id);
            $layanan->update(['nama_layanan' => $validated['nama_layanan']]);
        } elseif ($validated['type'] === 'kiloan') {
            $layanan = LayananKiloan::findOrFail($id);
            $layanan->update([
                'nama_paket' => $validated['nama_paket'],
                'durasi_hari' => $validated['durasi_hari'],
            ]);
        } elseif ($validated['type'] === 'satuan') {
            $layanan = LayananSatuan::findOrFail($id);
            $layanan->update(['nama_layanan' => $validated['nama_layanan']]);
        }

        return redirect()->route('superadmin.layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    // 4. Menghapus layanan berdasarkan tipe dan ID
    public function destroy($id, $type)
    {
        if ($type === 'jenis_layanan') {
            $layanan = JenisLayanan::findOrFail($id);
        } elseif ($type === 'kiloan') {
            $layanan = LayananKiloan::findOrFail($id);
        } elseif ($type === 'satuan') {
            $layanan = LayananSatuan::findOrFail($id);
        } else {
            return redirect()->back()->with('error', 'Tipe layanan tidak valid.');
        }

        $layanan->delete();
        return redirect()->route('superadmin.layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
