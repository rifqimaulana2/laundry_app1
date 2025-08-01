@extends('layouts.superadmin')

@section('title', 'Daftar Karyawan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Karyawan</h1>
        <a href="{{ route('superadmin.employees.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
            <i data-lucide="plus" class="w-5 h-5"></i> Tambah Karyawan
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-700">Nama</th>
                    <th class="p-4 text-sm font-semibold text-gray-700">Mitra</th>
                    <th class="p-4 text-sm font-semibold text-gray-700">No Telepon</th>
                    <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employees as $employee)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4 text-sm text-gray-800">{{ $employee->user->name }}</td>
                        <td class="p-4 text-sm text-gray-800">{{ $employee->mitra->nama_toko }}</td>
                        <td class="p-4 text-sm text-gray-800">{{ $employee->no_telepon }}</td>
                        <td class="p-4 flex gap-2">
                            <a href="{{ route('superadmin.employees.edit', $employee) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 flex items-center gap-2">
                                <i data-lucide="edit" class="w-4 h-4"></i> Edit
                            </a>
                            <form action="{{ route('superadmin.employees.destroy', $employee) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center gap-2" onclick="return confirm('Hapus karyawan?')">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-sm text-gray-500">Tidak ada karyawan ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection