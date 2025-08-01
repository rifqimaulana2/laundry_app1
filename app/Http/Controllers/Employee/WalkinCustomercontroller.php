<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\WalkinCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalkinCustomerController extends Controller
{
    public function index()
    {
        $mitraId = Auth::user()->employee->mitra_id;
        $customers = WalkinCustomer::where('mitra_id', $mitraId)->get();

        return view('employee.walkin_customer.index', compact('customers'));
    }

    public function create()
    {
        return view('employee.walkin_customer.create');
    }

    public function store(Request $request)
    {
        $mitraId = Auth::user()->employee->mitra_id;

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        WalkinCustomer::create([
            'nama' => $request->nama,
            'no_tlp' => $request->no_tlp,
            'alamat' => $request->alamat,
            'mitra_id' => $mitraId,
        ]);

        return redirect()->route('employee.pelanggan-walkin.index')->with('success', 'Walk-in customer berhasil ditambahkan.');
    }

    public function show(WalkinCustomer $walkinCustomer)
    {
        $mitraId = Auth::user()->employee->mitra_id;
        if ($walkinCustomer->mitra_id !== $mitraId) {
            abort(403, 'Unauthorized');
        }

        return view('employee.walkin_customer.show', compact('walkinCustomer'));
    }

    public function edit(WalkinCustomer $walkinCustomer)
    {
        $mitraId = Auth::user()->employee->mitra_id;
        if ($walkinCustomer->mitra_id !== $mitraId) {
            abort(403, 'Unauthorized');
        }

        return view('employee.walkin_customer.edit', compact('walkinCustomer'));
    }

    public function update(Request $request, WalkinCustomer $walkinCustomer)
    {
        $mitraId = Auth::user()->employee->mitra_id;
        if ($walkinCustomer->mitra_id !== $mitraId) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $walkinCustomer->update([
            'nama' => $request->nama,
            'no_tlp' => $request->no_tlp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('employee.pelanggan-walkin.index')->with('success', 'Walk-in customer berhasil diperbarui.');
    }
}
