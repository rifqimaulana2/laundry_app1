@extends('layouts.pelanggan')

@section('title', 'Edit Profil - LaundryKuy')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold text-indigo-600 mb-6">Edit Profil</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('pelanggan.profil.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Alamat -->
        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
            <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $profile->alamat) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('alamat') border-red-500 @enderror" required>
            @error('alamat')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nomor Telepon -->
        <div>
            <label for="no_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $profile->no_telepon ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('no_telepon') border-red-500 @enderror">
            @error('no_telepon')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Foto Profil -->
        <div>
            <label for="foto_profil" class="block text-sm font-medium text-gray-700">Foto Profil</label>
            <input type="file" name="foto_profil" id="foto_profil" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('foto_profil') border-red-500 @enderror">
            @if ($profile->foto_profil)
                <img src="{{ asset('storage/' . $profile->foto_profil) }}" alt="Foto Profil" class="mt-2 w-24 h-24 object-cover rounded-full">
            @endif
            @error('foto_profil')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @endif
        </div>

        <!-- Tombol Submit -->
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection