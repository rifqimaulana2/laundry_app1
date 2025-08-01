@extends('layouts.mitra')

@section('content')
    <div class="max-w-xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Profil Mitra</h1>
            <form action="{{ route('mitra.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Nama Toko</label>
                    <input type="text" name="nama_toko" value="{{ $mitra->nama_toko }}" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Kecamatan</label>
                    <input type="text" name="kecamatan" value="{{ $mitra->kecamatan }}" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>{{ $mitra->alamat_lengkap }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Longitude</label>
                        <input type="text" name="longitude" value="{{ $mitra->longitude }}" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Latitude</label>
                        <input type="text" name="latitude" value="{{ $mitra->latitude }}" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">No Telepon</label>
                    <input type="text" name="no_telepon" value="{{ $mitra->no_telepon }}" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Foto Toko</label>
                    <input type="file" name="foto_toko" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3">
                    @if ($mitra->foto_toko)
                        <img src="{{ asset('storage/' . $mitra->foto_toko) }}" width="100" class="mt-2 rounded-lg shadow">
                    @endif
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Foto Profil</label>
                    <input type="file" name="foto_profile" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3">
                    @if ($mitra->foto_profile)
                        <img src="{{ asset('storage/' . $mitra->foto_profile) }}" width="100" class="mt-2 rounded-lg shadow">
                    @endif
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">Simpan</button>
            </form>
        </div>
    </div>
@endsection