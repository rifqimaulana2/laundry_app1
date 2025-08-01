<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraApprovalController extends Controller
{
    public function index()
    {
        // Ambil mitra dengan status pending
        $mitras = Mitra::where('status_approve', 'pending')->with('user')->get();

        return view('superadmin.mitras.approval', compact('mitras'));
    }

    public function approve($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->status_approve = 'disetujui';
        $mitra->save();

        return redirect()->back()->with('success', 'Mitra berhasil disetujui.');
    }

    public function reject($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->status_approve = 'ditolak';
        $mitra->save();

        return redirect()->back()->with('success', 'Mitra berhasil ditolak.');
    }
}
