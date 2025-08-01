<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Tagihan;
use App\Models\Employee;
use App\Models\WalkinCustomer;

class DashboardController extends Controller
{
    public function index()
    {
        $mitraId = auth()->user()->mitra->id;
        $totalPesanans = Pesanan::where('mitra_id', $mitraId)->count();
        $totalTagihans = Tagihan::whereHas('pesanan', function ($query) use ($mitraId) {
            $query->where('mitra_id', $mitraId);
        })->where('status_pembayaran', 'belum lunas')->count();
        $totalEmployees = Employee::where('mitra_id', $mitraId)->count();
        $totalWalkinCustomers = WalkinCustomer::where('mitra_id', $mitraId)->count();

        return view('mitra.dashboard', compact(
            'totalPesanans',
            'totalTagihans',
            'totalEmployees',
            'totalWalkinCustomers'
        ));
    }
}
?>