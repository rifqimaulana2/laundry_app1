@extends('layouts.mitra')

@section('title', 'Pesanan Masuk')

@section('content')
<h1 class="text-xl font-semibold mb-4">Daftar Pesanan</h1>

<table class="table-auto w-full bg-white shadow rounded">
    <thead>
        <tr class="bg-blue-100 text-left">
            <th class="p-2">Pelanggan</th>
            <th class="p-2">Status</th>
            <th class="p-2">Total</th>
            <th class="p-2">Tanggal</th>
            <th class="p-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pesanan as $p)
        <tr class="border-t">
            <td class="p-2">{{ $p->user->name ?? $p->walkinCustomer->nama ?? '-' }}</td>
            <td class="p-2">{{ ucfirst($p->status_pesanan) }}</td>
            <td class="p-2">Rp{{ number_format($p->total_harga, 0, ',', '.') }}</td>
            <td class="p-2">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
            <td class="p-2">
                <a href="{{ route('mitra.pesanan.show', $p->id) }}" class="text-blue-600 underline">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
