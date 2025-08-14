<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Walkin_Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    // Menampilkan semua pesanan milik mitra pegawai
    public function index()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            abort(403, 'Anda bukan pegawai.');
        }

        $pesanans = Pesanan::where('mitra_id', $employee->mitra_id)
            ->with(['user', 'walkin_Customers'])
            ->latest()
            ->get();

        return view('employee.pesanan.index', compact('pesanans'));
    }

    // Menampilkan detail pesanan (dengan validasi mitra)
    public function show(Pesanan $pesanan)
    {
        $employee = Auth::user()->employee;

        if (!$employee || $pesanan->mitra_id !== $employee->mitra_id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $pesanan->load([
            'kiloanDetails.layananMitraKiloan.layananKiloan',
            'satuanDetails.layananMitraSatuan.layananSatuan',
            'tagihan',
            'user',
            'walkin_Customers'
        ]);

        return view('employee.pesanan.show', compact('pesanan'));
    }

    // Menampilkan form tambah pesanan
    public function create()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $walkinCustomers = Walkin_Customers::where('mitra_id', $employee->mitra_id)->get();

        return view('employee.pesanan.create', compact('walkin_Customers'));
    }

    // Menyimpan pesanan baru dari walk-in customer
    public function store(Request $request)
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $request->validate([
            'walkin_customer_id' => 'required|exists:walkin_customers,id',
            'jenis_pesanan' => 'required|string|in:Kiloan,Satuan,Kiloan + Satuan',
        ]);

        $pesanan = Pesanan::create([
            'walkin_customer_id' => $request->walkin_customer_id,
            'mitra_id' => $employee->mitra_id,
            'jenis_pesanan' => $request->jenis_pesanan,
            'tanggal_pesan' => now(),
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->route('employee.pesanan.index')->with('success', 'Pesanan berhasil ditambahkan.');
    }
}
