{{-- resources/views/superadmin/mitras/approval.blade.php --}}
@extends('layouts.superadmin')

@section('title', 'Persetujuan Mitra')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Persetujuan Pendaftaran Mitra</h1>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-700">Nama Toko</th>
                    <th class="p-4 text-sm font-semibold text-gray-700">Alamat</th>
                    <th class="p-4 text-sm font-semibold text-gray-700">No. Telepon</th>
                    <th class="p-4 text-sm font-semibold text-gray-700">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mitras as $mitra)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4 text-sm text-gray-800">{{ $mitra->nama_toko }}</td>
                        <td class="p-4 text-sm text-gray-800">{{ $mitra->alamat_lengkap }}</td>
                        <td class="p-4 text-sm text-gray-800">{{ $mitra->no_telepon }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-lg bg-yellow-100 text-yellow-800 text-xs font-semibold">{{ $mitra->status_approve }}</span>
                        </td>
                        <td class="p-4 flex gap-2">
                            <form method="POST" action="{{ route('superadmin.mitras.approve', $mitra->id) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                                    <i data-lucide="check" class="w-4 h-4"></i> Setujui
                                </button>
                            </form>
                            <form method="POST" action="{{ route('superadmin.mitras.reject', $mitra->id) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center gap-2">
                                    <i data-lucide="x" class="w-4 h-4"></i> Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-sm text-gray-500">Tidak ada mitra yang menunggu persetujuan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
