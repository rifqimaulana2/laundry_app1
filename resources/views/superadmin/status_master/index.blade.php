@extends('layouts.superadmin')

@section('title', 'Status Master')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Status</h1>
        <a href="{{ route('superadmin.status-master.create') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 font-semibold transition">
            + Tambah Status
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-semibold text-gray-700 w-16">#</th>
                        <th class="py-3 px-4 font-semibold text-gray-700">Nama Status</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 w-40 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($statuses as $status)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4 font-medium text-gray-800">{{ $status->nama_status }}</td>
                            <td class="py-3 px-4 text-center flex items-center justify-center gap-3">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('superadmin.status-master.edit', $status) }}" 
                                   class="px-3 py-1 bg-yellow-400 text-blue-900 rounded-lg text-xs font-semibold hover:bg-yellow-500 transition">
                                    Edit
                                </a>
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('superadmin.status-master.destroy', $status) }}" method="POST" 
                                      onsubmit="return confirm('Hapus status ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg text-xs font-semibold hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-6 text-gray-500">
                                Belum ada data status
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
