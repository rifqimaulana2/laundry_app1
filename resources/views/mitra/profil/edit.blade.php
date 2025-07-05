@extends('layouts.mitra')

@section('title', 'Edit Profil')

@section('content')
<h1 class="text-xl font-semibold mb-4">Edit Profil</h1>

<form method="POST" action="{{ route('mitra.profil.update') }}" class="bg-white p-4 rounded shadow">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block font-medium">Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $mitra->nama) }}" class="w-full p-2 border rounded">
    </div>

    <div class="mb-4">
        <label class="block font-medium">Nama Toko</label>
        <input type="text" name="nama_toko" value="{{ old('nama_toko', $mitra->nama_toko) }}" class="w-full p-2 border rounded">
    </div>

    <div class="mb-4">
        <label class="block font-medium">Alamat</label>
        <textarea name="alamat" class="w-full p-2 border rounded">{{ old('alamat', $mitra->alamat) }}</textarea>
    </div>

    <div class="mb-4">
        <label class="block font-medium">No Telepon</label>
        <input type="text" name="no_telepon" value="{{ old('no_telepon', $mitra->no_telepon) }}" class="w-full p-2 border rounded">
    </div>

    <div class="mb-4">
        <label class="block font-medium">Kecamatan</label>
        <input type="text" name="kecamatan" value="{{ old('kecamatan', $mitra->kecamatan) }}" class="w-full p-2 border rounded">
    </div>

    <div class="flex gap-4">
        <div class="mb-4 flex-1">
            <label class="block font-medium">Latitude</label>
            <input type="text" name="latitude" value="{{ old('latitude', $mitra->latitude) }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4 flex-1">
            <label class="block font-medium">Longitude</label>
            <input type="text" name="longitude" value="{{ old('longitude', $mitra->longitude) }}" class="w-full p-2 border rounded">
        </div>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
