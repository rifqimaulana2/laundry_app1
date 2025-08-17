<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\WalkinCustomer;
use Illuminate\Http\Request;

class WalkinCustomerController extends Controller
{
    public function index(Request $request)
    {
        $mitraId = auth()->user()->mitra->id;
        $query = WalkinCustomer::where('mitra_id', $mitraId);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('nama', 'like', "%$search%");
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
        $request->validate([
            'nama'   => 'required|string|max:255',
            'no_tlp' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        WalkinCustomer::create([
            'mitra_id' => auth()->user()->mitra->id,
            'nama'     => $request->nama,
            'no_tlp'   => $request->no_tlp,
            'alamat'   => $request->alamat,
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
            'nama'   => 'required|string|max:255',
            'no_tlp' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $walkinCustomer->update($request->all());

        return redirect()->route('mitra.walkin_customer.index')
            ->with('success', 'Pelanggan walk-in berhasil diperbarui.');
    }

    public function destroy(WalkinCustomer $walkinCustomer)
    {
        $this->authorize('delete', $walkinCustomer);

        $walkinCustomer->delete();

        return redirect()->route('mitra.walkin_customer.index')
            ->with('success', 'Pelanggan walk-in berhasil dihapus.');
    }
}
