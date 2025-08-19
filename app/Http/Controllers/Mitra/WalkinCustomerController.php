<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\WalkinCustomer;
use Illuminate\Http\Request;

class WalkinCustomerController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = null;

        if ($user->mitra) {
            $query = $user->mitra->walkinCustomers();
        } elseif ($user->role === 'employee' && $user->employee && $user->employee->mitra) {
            $query = $user->employee->mitra->walkinCustomers();
        }

        if (!$query) {
            return redirect()->back()->with('error', 'Anda belum terdaftar sebagai mitra.');
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        $walkinCustomers = $query->get();

        return view('mitra.walkin_customer.index', compact('walkinCustomers'));
    }

    public function create()
    {
        return view('mitra.walkin_customer.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $mitra = $user->mitra ?? ($user->employee->mitra ?? null);

        if (!$mitra) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar sebagai mitra.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'no_telepon'  => 'required|string|max:255',
            'alamat'      => 'required|string',
        ]);

        WalkinCustomer::create([
            'mitra_id'    => $mitra->id,
            'name'        => $request->name,
            'no_telepon'  => $request->no_telepon,
            'alamat'      => $request->alamat,
        ]);

        return redirect()->route('mitra.walkin_customer.index')
            ->with('success', 'Pelanggan walk-in berhasil ditambahkan.');
    }

    public function show(WalkinCustomer $walkinCustomer)
    {
        $this->authorize('view', $walkinCustomer);
        $walkinCustomer->load('pesanans');

        return view('mitra.walkin_customer.show', compact('walkinCustomer'));
    }

    public function edit(WalkinCustomer $walkinCustomer)
    {
        $this->authorize('update', $walkinCustomer);
        return view('mitra.walkin_customer.edit', compact('walkinCustomer'));
    }

    public function update(Request $request, WalkinCustomer $walkinCustomer)
    {
        $this->authorize('update', $walkinCustomer);

        $request->validate([
            'name'        => 'required|string|max:255',
            'no_telepon'  => 'required|string|max:255',
            'alamat'      => 'required|string',
        ]);

        $walkinCustomer->update([
            'name'        => $request->name,
            'no_telepon'  => $request->no_telepon,
            'alamat'      => $request->alamat,
        ]);

        return redirect()->route('mitra.walkin_customer.index')
            ->with('success', 'Pelanggan walk-in berhasil diperbarui.');
    }

    public function destroy(WalkinCustomer $walkinCustomer)
    {
        // $this->authorize('delete', $walkinCustomer);
        $walkinCustomer->delete();

        return redirect()->route('mitra.walkin_customer.index')
            ->with('success', 'Pelanggan walk-in berhasil dihapus.');
    }
}
