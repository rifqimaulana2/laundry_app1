<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    /**
     * Menampilkan daftar mitra + pencarian
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $mitras = Mitra::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_toko', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                      })
                      ->orWhere('kecamatan', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('superadmin.mitras.index', compact('mitras'));
    }

    /**
     * Menampilkan detail mitra (opsional)
     */
    public function show(Mitra $mitra)
    {
        return view('superadmin.mitras.show', compact('mitra'));
    }

    /**
     * Menghapus mitra
     */
    public function destroy(Mitra $mitra)
    {
        $mitra->delete();
        return redirect()->route('superadmin.mitras.index')->with('success', 'Mitra berhasil dihapus.');
    }

    /**
     * Approve mitra
     */
    public function approve($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->status_approve = 'disetujui';
        $mitra->save();

        return redirect()->route('superadmin.mitras.index')
                         ->with('success', 'Mitra berhasil disetujui.');
    }

    /**
     * Reject mitra
     */
    public function reject($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->status_approve = 'ditolak';
        $mitra->save();

        return redirect()->route('superadmin.mitras.index')
                         ->with('success', 'Mitra berhasil ditolak.');
    }
}
