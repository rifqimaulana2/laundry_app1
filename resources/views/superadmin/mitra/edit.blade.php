@extends('layouts.admin')

@section('title', 'Edit Mitra')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Edit Data Mitra</h1>

    <form action="{{ route('superadmin.mitra.update', $mitra->id) }}" method="POST"
          class="bg-white shadow p-6 rounded-lg space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label class="block font-medium">Nama Toko</label>
            <input type="text" name="nama_toko" value="{{ old('nama_toko', $mitra->nama_toko) }}"
                   class="w-full border-gray-300 rounded mt-1" required>
        </div>

        <div>
            <label class="block font-medium">Alamat</label>
            <textarea name="alamat" class="w-full border-gray-300 rounded mt-1" required>{{ old('alamat', $mitra->alamat) }}</textarea>
        </div>

        <div>
            <label class="block font-medium">No Telepon</label>
            <input type="text" name="no_telepon" value="{{ old('no_telepon', $mitra->no_telepon) }}"
                   class="w-full border-gray-300 rounded mt-1">
        </div>

        <div>
            <label class="block font-medium">Kecamatan</label>
            <input type="text" name="kecamatan" value="{{ old('kecamatan', $mitra->kecamatan) }}"
                   class="w-full border-gray-300 rounded mt-1">
        </div>

        <div class="flex justify-between items-center">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan Perubahan
            </button>
            <a href="{{ route('superadmin.mitra.index') }}" class="text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>
@endsection
