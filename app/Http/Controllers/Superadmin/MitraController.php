<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $mitras = Mitra::with('user')->get();
        return view('superadmin.mitras.index', compact('mitras'));
    }

    public function create()
    {
        $users = User::where('role', 'mitra')->doesntHave('mitra')->get();
        return view('superadmin.mitras.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_toko' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'longitude' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:255',
            'foto_toko' => 'nullable|image|max:2048',
            'foto_profile' => 'nullable|image|max:2048',
            'status_approve' => 'required|in:pending,disetujui,ditolak',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto_toko')) {
            $data['foto_toko'] = $request->file('foto_toko')->store('toko', 'public');
        }
        if ($request->hasFile('foto_profile')) {
            $data['foto_profile'] = $request->file('foto_profile')->store('profile', 'public');
        }

        Mitra::create($data);

        return redirect()->route('superadmin.mitras.index')->with('success', 'Mitra berhasil ditambahkan.');
    }

    public function edit(Mitra $mitra)
    {
        $users = User::where('role', 'mitra')->get();
        return view('superadmin.mitras.edit', compact('mitra', 'users'));
    }

    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_toko' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'longitude' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:255',
            'foto_toko' => 'nullable|image|max:2048',
            'foto_profile' => 'nullable|image|max:2048',
            'status_approve' => 'required|in:pending,disetujui,ditolak',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto_toko')) {
            $data['foto_toko'] = $request->file('foto_toko')->store('toko', 'public');
        }
        if ($request->hasFile('foto_profile')) {
            $data['foto_profile'] = $request->file('foto_profile')->store('profile', 'public');
        }

        $mitra->update($data);

        return redirect()->route('superadmin.mitras.index')->with('success', 'Mitra berhasil diperbarui.');
    }

    public function destroy(Mitra $mitra)
    {
        $mitra->delete();
        return redirect()->route('superadmin.mitras.index')->with('success', 'Mitra berhasil dihapus.');
    }

    // ✅ Tambahkan ini:
    public function show(Mitra $mitra)
    {
        return view('superadmin.mitras.show', compact('mitra'));
    }
}
