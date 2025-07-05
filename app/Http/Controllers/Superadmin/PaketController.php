<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PaketLangganan;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    // 1. Tampilkan semua paket langganan
    public function index()
    {
        $pakets = PaketLangganan::all();
        return view('superadmin.paket.index', compact('pakets'));
    }

    // 2. Simpan paket langganan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
        ]);

        PaketLangganan::create($validated);
        return redirect()->route('superadmin.paket.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    // 3. Tampilkan form edit paket
    public function edit($id)
    {
        $paket = PaketLangganan::findOrFail($id);
        return view('superadmin.paket.edit', compact('paket'));
    }

    // 4. Simpan perubahan paket
    public function update(Request $request, $id)
    {
        $paket = PaketLangganan::findOrFail($id);

        $validated = $request->validate([
            'nama_paket' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
        ]);

        $paket->update($validated);
        return redirect()->route('superadmin.paket.index')->with('success', 'Paket berhasil diperbarui.');
    }

    // 5. Hapus paket langganan
    public function destroy($id)
    {
        $paket = PaketLangganan::findOrFail($id);
        $paket->delete();

        return redirect()->route('superadmin.paket.index')->with('success', 'Paket berhasil dihapus.');
    }
}
