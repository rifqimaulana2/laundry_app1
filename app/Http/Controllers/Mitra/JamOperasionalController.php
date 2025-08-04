<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\JamOperasional;
use Illuminate\Http\Request;

class JamOperasionalController extends Controller
{
    public function index()
    {
        $mitraId = auth()->user()->mitra->id;
        $jamOperasionals = JamOperasional::where('mitra_id', $mitraId)->get();
        return view('mitra.jam_operasional.index', compact('jamOperasionals'));
    }

    public function create()
    {
        return view('mitra.jam_operasional.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
        ]);

        JamOperasional::create([
            'mitra_id' => auth()->user()->mitra->id,
            'hari' => $request->hari,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
        ]);

        return redirect()->route('mitra.jam-operasional.index')->with('success', 'Jam operasional berhasil ditambahkan.');
    }

    public function edit(JamOperasional $jamOperasional)
    {
        $this->authorize('update', $jamOperasional);
        return view('mitra.jam_operasional.edit', compact('jamOperasional'));
    }

    public function update(Request $request, JamOperasional $jamOperasional)
    {
        $this->authorize('update', $jamOperasional);
        $request->validate([
            'hari_buka' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',

        ]);

        $jamOperasional->update($request->all());

        return redirect()->route('mitra.jam-operasional.index')->with('success', 'Jam operasional berhasil diperbarui.');
    }

    public function destroy(JamOperasional $jamOperasional)
    {
        $this->authorize('delete', $jamOperasional);
        $jamOperasional->delete();
        return redirect()->route('mitra.jam-operasional.index')->with('success', 'Jam operasional berhasil dihapus.');
    }
}
?>