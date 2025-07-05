@extends('layouts.mitra')

@section('title', 'Detail Pesanan')

@section('content')
<h1 class="text-xl font-semibold mb-4">Detail Pesanan</h1>

<div class="bg-white shadow rounded p-4 mb-4">
    <p><strong>Pelanggan:</strong> {{ $pesanan->user->name ?? $pesanan->walkinCustomer->nama ?? '-' }}</p>
    <p><strong>Status Pesanan:</strong> {{ ucfirst($pesanan->status_pesanan) }}</p>
    <p><strong>Jenis:</strong> {{ ucfirst($pesanan->jenis_pesanan) }}</p>
    <p><strong>Tanggal Pesan:</strong> {{ $pesanan->waktu_pesan }}</p>
    <p><strong>Total Harga:</strong> Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
</div>

@if ($pesanan->jenis_pesanan === 'kiloan')
    <h2 class="text-lg font-semibold mb-2">Detail Kiloan</h2>
    <table class="table-auto w-full mb-4 bg-white shadow rounded">
        <thead class="bg-blue-100">
            <tr>
                <th class="p-2">Layanan</th>
                <th class="p-2">Berat (kg)</th>
                <th class="p-2">Harga/kg</th>
                <th class="p-2">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan->pesananDetailKiloan as $detail)
            <tr class="border-t">
                <td class="p-2">{{ $detail->layananMitraKiloan->layanan->nama_paket ?? '-' }}</td>
                <td class="p-2">{{ $detail->berat_real ?? '-' }}</td>
                <td class="p-2">Rp{{ number_format($detail->harga_per_kg, 0, ',', '.') }}</td>
                <td class="p-2">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-lg font-semibold mb-2">Detail Satuan</h2>
    <table class="table-auto w-full mb-4 bg-white shadow rounded">
        <thead class="bg-blue-100">
            <tr>
                <th class="p-2">Layanan</th>
                <th class="p-2">Jumlah</th>
                <th class="p-2">Harga/item</th>
                <th class="p-2">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan->pesananDetailSatuan as $detail)
            <tr class="border-t">
                <td class="p-2">{{ $detail->layananMitraSatuan->layanan->nama_layanan ?? '-' }}</td>
                <td class="p-2">{{ $detail->jumlah_item }}</td>
                <td class="p-2">Rp{{ number_format($detail->harga_per_item, 0, ',', '.') }}</td>
                <td class="p-2">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
