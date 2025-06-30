@extends('layouts.mitra')

@section('title', 'Layanan Saya')

@section('content')
<h2 class="text-xl font-semibold mb-4">Layanan Anda</h2>

<a href="{{ route('mitra.layanan.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded mb-4 inline-block">Tambah Layanan</a>

<table class="w-full text-sm bg-white rounded shadow">
    <thead class="bg-blue-800 text-white">
        <tr>
            <th class="p-3">Jenis</th>
            <th class="p-3">Nama</th>
            <th class="p-3">Harga</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($layanan as $item)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ ucfirst($item->tipe) }}</td>
                <td class="p-3">{{ $item->nama }}</td>
                <td class="p-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td class="p-3">
                    <a href="{{ route('mitra.layanan.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
