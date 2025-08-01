<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Tagihan;
use App\Models\WalkinCustomer;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            abort(403, 'Pegawai tidak ditemukan.');
        }

        $mitraId = $employee->mitra_id;

        $pesananCount = Pesanan::where('mitra_id', $mitraId)->count();

        $tagihanPending = Tagihan::whereIn('pesanan_id', function ($query) use ($mitraId) {
                $query->select('id')->from('pesanans')->where('mitra_id', $mitraId);
            })
            ->whereIn('status_pembayaran', ['belum lunas', 'dp_terbayar'])
            ->count();

        $walkinCount = WalkinCustomer::where('mitra_id', $mitraId)->count();

        return view('employee.dashboard', compact('pesananCount', 'tagihanPending', 'walkinCount'));
    }
}
