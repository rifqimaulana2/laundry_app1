<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $mitraId = Auth::user()->employee->mitra_id;

        $pesanans = Pesanan::where('mitra_id', $mitraId)
            ->with(['user', 'walkinCustomer'])
            ->get();

        return view('employee.pesanan.index', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        $mitraId = Auth::user()->employee->mitra_id;

        if ($pesanan->mitra_id !== $mitraId) {
            abort(403, 'Unauthorized');
        }

        $pesanan->load([
            'detailsKiloan.layananMitraKiloan.layananKiloan',
            'detailsSatuan.layananMitraSatuan.layananSatuan',
            'tagihan',
            'user',
            'walkinCustomer'
        ]);

        return view('employee.pesanan.show', compact('pesanan'));
    }
}
