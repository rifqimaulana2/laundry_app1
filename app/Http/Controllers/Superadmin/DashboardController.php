<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mitra;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalMitras = Mitra::where('status_approve', 'disetujui')->count();
        $totalApprovalMitra = Mitra::where('status_approve', 'pending')->count();


        // Data statistik bulanan
        $monthlyUserRegistrations = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyMitraRegistrations = Mitra::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = [];
        $users = [];
        $mitras = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->locale('id')->translatedFormat('F');
            $users[] = $monthlyUserRegistrations[$i] ?? 0;
            $mitras[] = $monthlyMitraRegistrations[$i] ?? 0;
        }

        return view('superadmin.dashboard', compact(
            'totalUsers',
            'totalMitras',
            'totalApprovalMitra',
            'months',
            'users',
            'mitras'
        ));
    }
}
