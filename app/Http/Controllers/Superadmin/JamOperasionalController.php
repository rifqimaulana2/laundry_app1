<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\JamOperasional;
use Illuminate\Http\Request;

class JamOperasionalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    // 1. Tampilkan semua jam operasional
    public function index()
    {
        $jams = JamOperasional::with('mitra')->get();
        return view('superadmin.jam.index', compact('jams'));
    }

    // 2. Form edit jam operasional
    public function edit($id)
    {
        $jam = JamOperasional::findOrFail($id);
        return view('superadmin.jam.edit', compact('jam'));
    }

    // 3. Simpan perubahan jam operasional
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'hari_buka' => 'required|string|max:20',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka',
        ]);

        JamOperasional::findOrFail($id)->update($validated);

        return redirect()->route('superadmin.jam.index')->with('success', 'Jam operasional diperbarui.');
    }
}
