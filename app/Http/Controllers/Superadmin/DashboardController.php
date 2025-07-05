<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\PelangganProfile;
use App\Models\Pesanan;
use App\Models\RiwayatTransaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    public function index()
    {
        $totalMitra = Mitra::count();
        $mitraDisetujui = Mitra::where('status_approve', 1)->count();
        $mitraBelumDisetujui = Mitra::where('status_approve', 0)->count();
        $mitraLanggananAktif = Mitra::where('langganan_aktif', 1)->count();
        $totalPelanggan = PelangganProfile::count();
        $totalTransaksi = Pesanan::count();
        $totalPendapatan = RiwayatTransaksi::sum('jumlah');

        $mitraPerBulan = Mitra::whereNotNull('created_at')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bulan, COUNT(*) as total")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $mitraLabels = [];
        foreach (array_keys($mitraPerBulan) as $bulan) {
            try {
                $mitraLabels[] = Carbon::createFromFormat('Y-m', $bulan)->format('F Y');
            } catch (\Exception $e) {
                $mitraLabels[] = $bulan;
            }
        }

        $mitraData = array_values($mitraPerBulan);

        return view('superadmin.dashboard.index', compact(
            'totalMitra',
            'mitraDisetujui',
            'mitraBelumDisetujui',
            'mitraLanggananAktif',
            'totalPelanggan',
            'totalTransaksi',
            'totalPendapatan',
            'mitraLabels',
            'mitraData'
        ));
    }
}
