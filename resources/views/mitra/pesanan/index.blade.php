@extends('layouts.mitra')

@section('title', 'Pesanan Masuk')

@section('content')
<h2 class="text-xl font-semibold mb-4">Daftar Pesanan</h2>

<table class="w-full text-sm bg-white rounded shadow">
    <thead class="bg-blue-800 text-white">
        <tr>
            <th class="p-3">Kode</th>
            <th class="p-3">Pelanggan</th>
            <th class="p-3">Tipe</th>
            <th class="p-3">Status</th>
            <th class="p-3">Total</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pesanan as $item)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $item->kode }}</td>
                <td class="p-3">{{ $item->user->name }}</td>
                <td class="p-3">{{ ucfirst($item->jenis_layanan) }}</td>
                <td class="p-3">{{ ucfirst($item->status) }}</td>
                <td class="p-3">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                <td class="p-3">
                    <a href="{{ route('mitra.pesanan.show', $item->id) }}" class="text-blue-600 hover:underline">Detail</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
