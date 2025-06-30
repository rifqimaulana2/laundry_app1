@extends('layouts.admin')

@section('title', 'Paket Langganan')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Paket Langganan Mitra</h1>

    {{-- Tombol Tambah (opsional) --}}
    <div class="mb-4">
        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Paket
        </a>
    </div>

    {{-- Tabel Paket --}}
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-3">Nama Paket</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Durasi</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pakets as $paket)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $paket->nama_paket }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $paket->durasi }} hari</td>
                    <td class="px-4 py-2">{{ $paket->deskripsi }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="#" class="text-yellow-600 hover:underline">Edit</a>
                        <a href="#" class="text-red-600 hover:underline"
                           onclick="return confirm('Yakin ingin menghapus paket ini?')">Hapus</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
