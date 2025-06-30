@extends('layouts.mitra')
@section('title', 'Edit Profil Toko')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded-lg">
    <h2 class="text-xl font-bold mb-4">Edit Profil Toko</h2>

    <form method="POST" action="{{ route('mitra.profil.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold">Nama Toko</label>
            <input type="text" name="nama_toko" class="w-full border rounded p-2"
                value="{{ old('nama_toko', $mitra->nama_toko ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Alamat</label>
            <textarea name="alamat" class="w-full border rounded p-2" required>{{ old('alamat', $mitra->alamat ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">No Telepon</label>
            <input type="text" name="no_telepon" class="w-full border rounded p-2"
                value="{{ old('no_telepon', $mitra->no_telepon ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Latitude</label>
            <input type="text" name="latitude" class="w-full border rounded p-2"
                value="{{ old('latitude', $mitra->latitude ?? '') }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Longitude</label>
            <input type="text" name="longitude" class="w-full border rounded p-2"
                value="{{ old('longitude', $mitra->longitude ?? '') }}">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('mitra.profil.index') }}" class="text-gray-600 hover:underline">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
