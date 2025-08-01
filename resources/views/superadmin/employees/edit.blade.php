@extends('layouts.superadmin')

@section('title', 'Edit Karyawan')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Karyawan</h1>
        <a href="{{ route('superadmin.employees.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali
        </a>
    </div>

    <form action="{{ route('superadmin.employees.update', $employee) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-lg">
        @csrf
        @method('PUT')
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Karyawan (User)</label>
            <select name="user_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('user_id') border-red-500 @enderror" required>
                <option value="" disabled>Pilih Pengguna</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $employee->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Mitra</label>
            <select name="mitra_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mitra_id') border-red-500 @enderror" required>
                <option value="" disabled>Pilih Mitra</option>
                @foreach ($mitras as $mitra)
                    <option value="{{ $mitra->id }}" {{ $employee->mitra_id == $mitra->id ? 'selected' : '' }}>{{ $mitra->nama_toko }}</option>
                @endforeach
            </select>
            @error('mitra_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">No Telepon</label>
            <input type="text" name="no_telepon" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_telepon') border-red-500 @enderror" value="{{ old('no_telepon', $employee->no_telepon) }}" required>
            @error('no_telepon')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('superadmin.employees.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection