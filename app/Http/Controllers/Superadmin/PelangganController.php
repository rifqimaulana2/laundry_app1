<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PelangganProfile;
use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    // 1. Tampilkan daftar pelanggan
    public function index()
    {
        $pelanggans = PelangganProfile::with('user')->get();
        return view('superadmin.pelanggan.index', compact('pelanggans'));
    }

    // 2. Form edit data pelanggan
    public function edit($id)
    {
        $pelanggan = PelangganProfile::with('user')->findOrFail($id);
        return view('superadmin.pelanggan.edit', compact('pelanggan'));
    }

    // 3. Simpan perubahan data pelanggan
    public function update(Request $request, $id)
    {
        $pelanggan = PelangganProfile::findOrFail($id);

        // Update data dari tabel pelanggan_profiles
        $validated = $request->validate([
            'no_tlp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string|max:100',
        ]);
        $pelanggan->update($validated);

        // Update data dari tabel users (jika ada perubahan nama/email)
        if ($request->has('name') || $request->has('email')) {
            $userValidated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:255|unique:users,email,' . $pelanggan->user_id,
            ]);
            $pelanggan->user->update($userValidated);
        }

        return redirect()->route('superadmin.pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    // 4. Hapus pelanggan (hanya jika tidak ada pesanan aktif)
    public function destroy($id)
    {
        $pelanggan = PelangganProfile::findOrFail($id);

        if ($pelanggan->user->pesanan()->exists()) {
            return redirect()->back()->with('error', 'Pelanggan memiliki pesanan aktif dan tidak dapat dihapus.');
        }

        // Hapus user → akan otomatis menghapus pelanggan_profile karena relasi
        $pelanggan->user->delete();

        return redirect()->route('superadmin.pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
