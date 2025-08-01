<!-- resources/views/superadmin/transaksi/show.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="container">
        <h1>Detail Transaksi #{{ $transaksi->id }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Pesanan ID:</strong> {{ $transaksi->pesanan->id }}</p>
                <p><strong>Pelanggan:</strong> {{ $transaksi->pesanan->user ? $transaksi->pesanan->user->name : $transaksi->pesanan->walkinCustomer->nama }}</p>
                <p><strong>Mitra:</strong> {{ $transaksi->pesanan->mitra->nama_toko }}</p>
                <p><strong>Nominal:</strong> Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</p>
                <p><strong>Jenis Transaksi:</strong> {{ $transaksi->jenis_transaksi }}</p>
                <p><strong>Metode Bayar:</strong> {{ $transaksi->metode_bayar }}</p>
                <p><strong>Waktu:</strong> {{ $transaksi->waktu }}</p>
            </div>
        </div>
    </div>
@endsection