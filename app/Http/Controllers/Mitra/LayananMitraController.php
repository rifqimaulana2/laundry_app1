<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\LayananKiloan;
use App\Models\LayananSatuan;
use App\Models\LayananMitraKiloan;
use App\Models\LayananMitraSatuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayananMitraController extends Controller
{
    public function index()
    {
        $mitra = Auth::user()->mitra;
        $layananKiloan = $mitra->layananMitraKiloan()->with('layanan')->get();
        $layananSatuan = $mitra->layananMitraSatuan()->with('layanan')->get();

        return view('mitra.layanan.index', compact('layananKiloan', 'layananSatuan'));
    }

    public function create()
    {
        $paketKiloan = LayananKiloan::all();
        $paketSatuan = LayananSatuan::all();
        return view('mitra.layanan.create', compact('paketKiloan', 'paketSatuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:kiloan,satuan',
            'layanan_id' => 'required|integer',
            'harga' => 'required|numeric|min:0',
        ]);

        $mitra = Auth::user()->mitra;

        if ($request->type === 'kiloan') {
            LayananMitraKiloan::create([
                'mitras_id' => $mitra->id,
                'layanan_kiloan_id' => $request->layanan_id,
                'harga_per_kg' => $request->harga,
            ]);
        } else {
            LayananMitraSatuan::create([
                'mitras_id' => $mitra->id,
                'layanan_satuan_id' => $request->layanan_id,
                'harga_per_item' => $request->harga,
            ]);
        }

        return redirect()->route('mitra.layanan.index')->with('success', 'Layanan ditambahkan.');
    }
}
