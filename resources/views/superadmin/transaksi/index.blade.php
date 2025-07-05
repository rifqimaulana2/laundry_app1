@extends('layouts.admin')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Transaksi</h1>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Mitra</th>
                <th>Status</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $pesanan)
            <tr>
                <td>#{{ $pesanan->id }}</td>
                <td>{{ $pesanan->pelangganProfile->user->name ?? '-' }}</td>
                <td>{{ $pesanan->mitra->nama_toko ?? '-' }}</td>
                <td>{{ $pesanan->status }}</td>
                <td>Rp{{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
                <td>{{ $pesanan->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
