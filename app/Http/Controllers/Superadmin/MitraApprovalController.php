<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MitraApprovalController extends Controller
{
    /**
     * Menampilkan daftar mitra yang belum punya data toko (belum isi mitras)
     */
    public function index()
    {
        // Ambil user dengan role mitra dan belum isi data mitras
        $mitras = User::role('mitra')
            ->whereDoesntHave('mitra')
            ->where('status_approve', 0)
            ->get();

        return view('superadmin.mitra.pending', compact('mitras'));
    }

    /**
     * Menyetujui mitra (set status_approve = 1)
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status_approve' => 1,
        ]);

        return redirect()->back()->with('success', 'Mitra berhasil disetujui. Silakan login dan lengkapi profil.');
    }

    /**
     * Menolak mitra (hapus user)
     */
    public function reject($id)
    {
        $user = User::findOrFail($id);

        // Hapus user (otomatis akan menghapus data mitra jika ada relasi cascade)
        $user->delete();

        return redirect()->back()->with('success', 'Pendaftaran mitra ditolak dan dihapus.');
    }
}
