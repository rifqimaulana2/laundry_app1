@extends('layouts.admin')

@section('title', 'Manajemen Mitra')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Daftar Mitra</h1>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-3">Nama Toko</th>
                    <th class="px-4 py-3">Alamat</th>
                    <th class="px-4 py-3">Telepon</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Langganan</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mitras as $mitra)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $mitra->nama_toko }}</td>
                    <td class="px-4 py-2">{{ $mitra->alamat }}</td>
                    <td class="px-4 py-2">{{ $mitra->no_telepon }}</td>
                    <td class="px-4 py-2">
                        {{ $mitra->status_approve ? 'Disetujui' : 'Menunggu Verifikasi' }}
                    </td>
                    <td class="px-4 py-2">
                        {{ optional($mitra->langgananMitra)->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('superadmin.mitra.show', $mitra->id) }}"
                           class="text-blue-600 hover:underline">Lihat</a>
                        <a href="{{ route('superadmin.mitra.edit', $mitra->id) }}"
                           class="text-yellow-600 hover:underline">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
