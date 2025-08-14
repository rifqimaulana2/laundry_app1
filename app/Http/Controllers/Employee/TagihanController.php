<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index()
    {
        $mitraId = Auth::user()->employee->mitra_id;

        $tagihans = Tagihan::whereHas('pesanan', function ($query) use ($mitraId) {
            $query->where('mitra_id', $mitraId);
        })
        ->with(['pesanan.user', 'pesanan.walkin_Customers'])
        ->get();

        return view('employee.tagihan.index', compact('tagihans'));
    }

    public function show(Tagihan $tagihan)
    {
        $mitraId = Auth::user()->employee->mitra_id;

        if ($tagihan->pesanan->mitra_id !== $mitraId) {
            abort(403, 'Unauthorized');
        }

        $tagihan->load(['pesanan.user', 'pesanan.walkin_Customers']);

        return view('employee.tagihan.show', compact('tagihan'));
    }
}
