@extends('layouts.superadmin')

@section('title', 'Tambah Layanan Satuan')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Layanan Satuan</h1>
        <a href="{{ route('superadmin.layanan-satuan.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali
        </a>
    </div>

    <form action="{{ route('superadmin.layanan-satuan.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-lg">
        @csrf
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
            <select name="jenis_layanan_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis_layanan_id') border-red-500 @enderror" required>
                <option value="" disabled selected>Pilih Jenis Layanan</option>
                @foreach ($jenisLayanans as $jenis)
                    <option value="{{ $jenis->id }}">{{ $jenis->nama_layanan }}</option>
                @endforeach
            </select>
            @error('jenis_layanan_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan</label>
            <input type="text" name="nama_layanan" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_layanan') border-red-500 @enderror" value="{{ old('nama_layanan') }}" required>
            @error('nama_layanan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('superadmin.layanan-satuan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection