@extends('layouts.superadmin')

@section('title', 'Tambah Status')

@section('content')
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Status Baru</h1>

    <form action="{{ route('superadmin.status-master.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow space-y-6">
        @csrf

        <div>
            <label for="nama_status" class="block font-medium text-gray-700 mb-2">Nama Status</label>
            <input type="text" name="nama_status" id="nama_status" required
                   class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   value="{{ old('nama_status') }}">
            @error('nama_status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('superadmin.status-master.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</a>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
