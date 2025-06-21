@extends('layouts.app')

@section('title', 'Profil Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gradient-to-br from-teal-50 to-blue-100 min-h-screen">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-4 animate-fade-in">Profil Saya</h1>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto">Kelola informasi pribadi Anda untuk pengalaman laundry yang lebih mudah.</p>
    </div>

    <section class="bg-white shadow-xl rounded-2xl p-8">
        <form action="{{ route('pelanggan.update.profil') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (session('success'))
                <div class="bg-teal-100 border border-teal-400 text-teal-700 px-4 py-3 rounded mb-4 animate-fade-in" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 animate-fade-in" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', auth()->user()->nama ?? '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon', auth()->user()->telepon ?? '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 @error('telepon') border-red-500 @enderror">
                    @error('telepon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Penjemputan</label>
                <textarea name="alamat" id="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', auth()->user()->alamat ?? '') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-gradient-to-r from-teal-600 to-blue-800 text-white px-6 py-3 rounded-lg hover:from-teal-700 hover:to-blue-900 transition duration-300 transform hover:scale-105 font-semibold">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endsection