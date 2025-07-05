<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    // 1. Tampilkan semua notifikasi (bisa difilter nanti kalau perlu)
    public function index()
    {
        $notifikasis = Notifikasi::with('user')->latest()->get();
        return view('superadmin.notifikasi.index', compact('notifikasis'));
    }

    // 2. Tandai notifikasi sebagai telah dibaca
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->update(['status_baca' => true]);

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai dibaca.');
    }

    // 3. Hapus notifikasi
    public function destroy($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
