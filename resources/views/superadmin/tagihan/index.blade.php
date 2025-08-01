<!-- resources/views/superadmin/tagihan/index.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="container">
        <h1>Daftar Tagihan</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Mitra</th>
                    <th>Total Tagihan</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tagihans as $tagihan)
                    <tr>
                        <td>{{ $tagihan->id }}</td>
                        <td>{{ $tagihan->pesanan->id }}</td>
                        <td>{{ $tagihan->pesanan->user ? $tagihan->pesanan->user->name : $tagihan->pesanan->walkinCustomer->nama }}</td>
                        <td>{{ $tagihan->pesanan->mitra->nama_toko }}</td>
                        <td>Rp {{ number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $tagihan->status_pembayaran }}</td>
                        <td>
                            <a href="{{ route('superadmin.tagihan.show', $tagihan) }}" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection