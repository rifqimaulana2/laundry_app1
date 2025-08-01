<?php
// app/Http/Controllers/Superadmin/LayananKiloanController.php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\LayananKiloan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;

class LayananKiloanController extends Controller
{
    public function index()
    {
        $layananKiloans = LayananKiloan::with('jenisLayanan')->get();
        return view('superadmin.layanan.kiloan', compact('layananKiloans'));
    }

    public function create()
    {
        $jenisLayanans = JenisLayanan::where('nama_layanan', 'kiloan')->get();
        return view('superadmin.layanan.kiloan_create', compact('jenisLayanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan_id' => 'required|exists:jenis_layanan,id',
            'nama_paket' => 'required|string|max:255',
        ]);

        LayananKiloan::create($request->all());

        return redirect()->route('superadmin.layanan-kiloan.index')->with('success', 'Layanan kiloan berhasil ditambahkan.');
    }

    public function edit(LayananKiloan $layananKiloan)
    {
        $jenisLayanans = JenisLayanan::where('nama_layanan', 'kiloan')->get();
        return view('superadmin.layanan.kiloan_edit', compact('layananKiloan', 'jenisLayanans'));
    }

    public function update(Request $request, LayananKiloan $layananKiloan)
    {
        $request->validate([
            'jenis_layanan_id' => 'required|exists:jenis_layanan,id',
            'nama_paket' => 'required|string|max:255',
        ]);

        $layananKiloan->update($request->all());

        return redirect()->route('superadmin.layanan-kiloan.index')->with('success', 'Layanan kiloan berhasil diperbarui.');
    }

    public function destroy(LayananKiloan $layananKiloan)
    {
        $layananKiloan->delete();
        return redirect()->route('superadmin.layanan-kiloan.index')->with('success', 'Layanan kiloan berhasil dihapus.');
    }
}