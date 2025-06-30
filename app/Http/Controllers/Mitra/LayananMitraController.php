<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananKiloan;
use App\Models\LayananSatuan;
use Illuminate\Support\Facades\Auth;

class LayananMitraController extends Controller
{
    public function index()
    {
        $kiloan = LayananKiloan::where('mitra_id', Auth::id())->get();
        $satuan = LayananSatuan::where('mitra_id', Auth::id())->get();

        $layanan = $kiloan->merge($satuan);

        return view('mitra.layanan.index', compact('layanan'));
    }

    public function create()
    {
        return view('mitra.layanan.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'tipe' => 'required|in:kiloan,satuan',
        ]);

        $data['mitra_id'] = Auth::id();

        if ($data['tipe'] === 'kiloan') {
            LayananKiloan::create($data);
        } else {
            LayananSatuan::create($data);
        }

        return redirect()->route('mitra.layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $layanan = LayananKiloan::find($id) ?? LayananSatuan::findOrFail($id);
        return view('mitra.layanan.form', compact('layanan'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'tipe' => 'required|in:kiloan,satuan',
        ]);

        $layanan = ($data['tipe'] === 'kiloan')
            ? LayananKiloan::where('mitra_id', Auth::id())->findOrFail($id)
            : LayananSatuan::where('mitra_id', Auth::id())->findOrFail($id);

        $layanan->update($data);

        return redirect()->route('mitra.layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }
}
