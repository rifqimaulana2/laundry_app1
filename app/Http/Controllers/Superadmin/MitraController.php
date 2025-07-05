<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    public function index()
    {
        $mitras = Mitra::with(['user', 'layananKiloan', 'layananSatuan'])->latest()->get();
        return view('superadmin.mitra.index', compact('mitras'));
    }

    public function pending()
    {
        $mitras = User::role('mitra')
            ->whereDoesntHave('mitra')
            ->get();
        return view('superadmin.mitra.pending', compact('mitras'));
    }

    public function show($id)
    {
        $mitra = Mitra::with(['user', 'layananKiloan', 'layananSatuan'])->findOrFail($id);
        return view('superadmin.mitra.show', compact('mitra'));
    }

    public function edit($id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('superadmin.mitra.edit', compact('mitra'));
    }

    public function update(Request $request, $id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->update($request->validate([
            'nama' => 'required|string|max:100',
            'nama_toko' => 'required|string|max:100',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'kecamatan' => 'nullable|string|max:100',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
        ]));

        return redirect()->route('superadmin.mitra.index')->with('success', 'Mitra diperbarui.');
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);

        // ❗ Tidak perlu menyalin nama/alamat/usaha ke mitras — itu akan diisi oleh mitra nanti
        Mitra::create([
            'user_id' => $user->id,
            'status_approve' => true,
            'langganan_aktif' => true,
            'tanggal_langganan_berakhir' => now()->addYear(),
        ]);

        return redirect()->route('superadmin.mitra.pending')->with('success', 'Mitra disetujui. Silakan login dan lengkapi profil.');
    }

    public function approveMitra($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->update([
            'status_approve' => true,
            'langganan_aktif' => true,
            'tanggal_langganan_berakhir' => now()->addYear(),
        ]);

        return redirect()->route('superadmin.mitra.index')->with('success', 'Mitra disetujui.');
    }

    public function deactivate($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->update([
            'langganan_aktif' => false,
            'tanggal_langganan_berakhir' => null,
        ]);

        return redirect()->route('superadmin.mitra.index')->with('success', 'Langganan mitra dinonaktifkan.');
    }

    public function extend(Request $request, $id)
    {
        $request->validate(['durasi_bulan' => 'required|integer|min:1']);
        $mitra = Mitra::findOrFail($id);
        $mitra->update([
            'langganan_aktif' => true,
            'tanggal_langganan_berakhir' => $mitra->tanggal_langganan_berakhir
                ? $mitra->tanggal_langganan_berakhir->addMonths($request->durasi_bulan)
                : now()->addMonths($request->durasi_bulan),
        ]);

        return redirect()->route('superadmin.mitra.index')->with('success', 'Langganan mitra diperpanjang.');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        if ($user->pesanan()->exists()) {
            return redirect()->back()->with('error', 'User memiliki pesanan aktif dan tidak dapat dihapus.');
        }
        $user->delete();

        return redirect()->route('superadmin.mitra.pending')->with('success', 'Pendaftaran mitra ditolak.');
    }

    public function destroy($id)
    {
        $mitra = Mitra::findOrFail($id);
        if ($mitra->pesanan()->exists()) {
            return redirect()->back()->with('error', 'Mitra memiliki pesanan aktif dan tidak dapat dihapus.');
        }
        $mitra->delete();

        return redirect()->route('superadmin.mitra.index')->with('success', 'Mitra dihapus.');
    }
}
