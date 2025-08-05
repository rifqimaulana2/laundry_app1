@extends('layouts.superadmin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 px-6">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Mitra</h1>
        <form action="{{ route('superadmin.mitras.update', $mitra) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Pemilik (User)</label>
                <select name="user_id" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $mitra->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Toko</label>
                <input type="text" name="nama_toko" value="{{ $mitra->nama_toko }}" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ $mitra->kecamatan }}" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Alamat Lengkap</label>
                <textarea name="alamat_lengkap" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>{{ $mitra->alamat_lengkap }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Longitude</label>
                    <input type="text" name="longitude" value="{{ $mitra->longitude }}" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Latitude</label>
                    <input type="text" name="latitude" value="{{ $mitra->latitude }}" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">No Telepon</label>
                <input type="text" name="no_telepon" value="{{ $mitra->no_telepon }}" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Foto Toko</label>
                <input type="file" name="foto_toko" class="w-full text-sm text-gray-500">
                @if ($mitra->foto_toko)
                    <img src="{{ asset('storage/' . $mitra->foto_toko) }}" alt="Foto Toko" class="mt-2 w-24 rounded-md shadow">
                @endif
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Foto Profil</label>
                <input type="file" name="foto_profile" class="w-full text-sm text-gray-500">
                @if ($mitra->foto_profile)
                    <img src="{{ asset('storage/' . $mitra->foto_profile) }}" alt="Foto Profil" class="mt-2 w-24 rounded-full shadow">
                @endif
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status Approve</label>
                <select name="status_approve" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="pending" {{ $mitra->status_approve == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ $mitra->status_approve == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ $mitra->status_approve == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
