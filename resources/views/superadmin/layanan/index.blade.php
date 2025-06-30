@extends('layouts.admin')

@section('title', 'Layanan Global')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Layanan Global</h1>

    {{-- Layanan Kiloan --}}
    <div class="bg-white shadow rounded-lg mb-6 p-6">
        <h2 class="text-lg font-semibold text-blue-700 mb-3">Layanan Kiloan</h2>
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-2">Nama Layanan</th>
                    <th class="px-4 py-2">Harga/kg</th>
                    <th class="px-4 py-2">Deskripsi</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layananKiloans as $layanan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $layanan->nama_layanan }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $layanan->deskripsi }}</td>
                    <td class="px-4 py-2">
                        <a href="#" class="text-yellow-600 hover:underline">Edit</a>
                        <a href="#" class="text-red-600 hover:underline"
                           onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Layanan Satuan --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-blue-700 mb-3">Layanan Satuan</h2>
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-2">Nama Barang</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Deskripsi</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layananSatuans as $layanan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $layanan->nama_barang }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $layanan->deskripsi }}</td>
                    <td class="px-4 py-2">
                        <a href="#" class="text-yellow-600 hover:underline">Edit</a>
                        <a href="#" class="text-red-600 hover:underline"
                           onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
