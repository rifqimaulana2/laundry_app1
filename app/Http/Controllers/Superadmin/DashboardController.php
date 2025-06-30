<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\LanggananMitra;
use App\Models\PelangganProfile;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMitra = Mitra::count();
        $mitraDisetujui = Mitra::where('status_approve', 1)->count();
        $mitraBelumDisetujui = Mitra::where('status_approve', 0)->count();
        $mitraLanggananAktif = LanggananMitra::where('status', 'aktif')->count();
        $totalPelanggan = PelangganProfile::count();
        $totalTransaksi = Pesanan::count();

        $mitraPerBulan = Mitra::selectRaw("DATE_FORMAT(created_at, '%M %Y') as bulan, COUNT(*) as total")
            ->groupBy('bulan')
            ->orderByRaw("MIN(created_at)")
            ->pluck('total', 'bulan')
            ->toArray();

        $mitraLabels = array_keys($mitraPerBulan);
        $mitraData = array_values($mitraPerBulan);

        $mitras = Mitra::with('langgananMitra')->get();

        return view('superadmin.dashboard', compact(
            'totalMitra',
            'mitraDisetujui',
            'mitraBelumDisetujui',
            'mitraLanggananAktif',
            'totalPelanggan',
            'totalTransaksi',
            'mitraLabels',
            'mitraData',
            'mitras'
        ));
    }

    public function approveMitra($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->status_approve = 1;
        $mitra->save();

        return redirect()->back()->with('success', 'Mitra berhasil disetujui.');
    }

    public function rejectMitra($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();

        return redirect()->back()->with('success', 'Mitra berhasil ditolak.');
    }
}
