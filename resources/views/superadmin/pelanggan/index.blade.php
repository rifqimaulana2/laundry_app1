@extends('layouts.admin')

@section('title', 'Manajemen Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Daftar Pelanggan</h1>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Nomor Telepon</th>
                    <th class="px-4 py-3">Alamat</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pelanggans as $pelanggan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $pelanggan->user->name }}</td>
                    <td class="px-4 py-2">{{ $pelanggan->user->email }}</td>
                    <td class="px-4 py-2">{{ $pelanggan->no_telepon ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $pelanggan->alamat ?? '-' }}</td>
                    <td class="px-4 py-2">
                        {{-- Opsional: Tombol hapus, detail, dll --}}
                        <button class="text-gray-500 italic" disabled>Tidak ada aksi</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
