@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Laporan Transaksi</h1>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Pelanggan</th>
                    <th class="px-4 py-3">Mitra</th>
                    <th class="px-4 py-3">Jenis</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $pesanan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2 font-mono">{{ $pesanan->kode_unik }}</td>
                    <td class="px-4 py-2">{{ $pesanan->pelangganProfile->user->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $pesanan->mitra->nama_toko ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $pesanan->jenis_layanan }}</td>
                    <td class="px-4 py-2">{{ $pesanan->status }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $pesanan->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
