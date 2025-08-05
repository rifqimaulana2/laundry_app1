@extends('layouts.superadmin')

@section('title', 'Edit Jenis Layanan')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Jenis Layanan</h1>
        <a href="{{ route('superadmin.layanan-master.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali
        </a>
    </div>

    <form action="{{ route('superadmin.layanan-master.jenis.update', $jenisLayanan) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-lg">
        @csrf
        @method('PUT')
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan</label>
            <select name="nama_layanan" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_layanan') border-red-500 @enderror" required>
                <option value="kiloan" {{ $jenisLayanan->nama_layanan == 'kiloan' ? 'selected' : '' }}>Kiloan</option>
                <option value="satuan" {{ $jenisLayanan->nama_layanan == 'satuan' ? 'selected' : '' }}>Satuan</option>
            </select>
            @error('nama_layanan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('superadmin.layanan-master.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection