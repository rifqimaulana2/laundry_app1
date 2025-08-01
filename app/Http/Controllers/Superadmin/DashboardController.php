<?php

// app/Http/Controllers/Superadmin/DashboardController.php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mitra;
use App\Models\Employee;
use App\Models\Pesanan;
use App\Models\Tagihan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalMitras = Mitra::count();
        $totalEmployees = Employee::count();
        $totalPesanans = Pesanan::count();
        $totalTagihans = Tagihan::where('status_pembayaran', 'belum lunas')->count();

        return view('superadmin.dashboard', compact(
            'totalUsers',
            'totalMitras',
            'totalEmployees',
            'totalPesanans',
            'totalTagihans'
        ));
    }
}