<!-- resources/views/superadmin/transaksi/index.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="container">
        <h1>Daftar Transaksi</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Mitra</th>
                    <th>Nominal</th>
                    <th>Jenis Transaksi</th>
                    <th>Metode Bayar</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $transaksi)
                    <tr>
                        <td>{{ $transaksi->id }}</td>
                        <td>{{ $transaksi->pesanan->id }}</td>
                        <td>{{ $transaksi->pesanan->user ? $transaksi->pesanan->user->name : $transaksi->pesanan->walkinCustomer->nama }}</td>
                        <td>{{ $transaksi->pesanan->mitra->nama_toko }}</td>
                        <td>Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                        <td>{{ $transaksi->jenis_transaksi }}</td>
                        <td>{{ $transaksi->metode_bayar }}</td>
                        <td>{{ $transaksi->waktu }}</td>
                        <td>
                            <a href="{{ route('superadmin.transaksi.show', $transaksi) }}" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection