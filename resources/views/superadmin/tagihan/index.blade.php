@extends('layouts.admin')

@section('title', 'Tagihan Pembayaran')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Tagihan Pembayaran</h1>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Mitra</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tagihans as $tagihan)
            <tr>
                <td>#{{ $tagihan->id }}</td>
                <td>{{ $tagihan->pesanan->pelangganProfile->user->name ?? '-' }}</td>
                <td>{{ $tagihan->pesanan->mitra->nama_toko ?? '-' }}</td>
                <td>Rp{{ number_format($tagihan->total, 0, ',', '.') }}</td>
                <td>
                    {!! $tagihan->status == 'lunas'
                        ? '<span class="badge badge-success">Lunas</span>'
                        : '<span class="badge badge-warning">Belum Dibayar</span>' !!}
                </td>
                <td>{{ $tagihan->created_at->format('d M Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada tagihan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
