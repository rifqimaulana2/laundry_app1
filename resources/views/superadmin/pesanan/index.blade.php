<!-- resources/views/superadmin/pesanan/index.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="container">
        <h1>Daftar Pesanan</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Mitra</th>
                    <th>Jenis Pesanan</th>
                    <th>Tanggal Pesan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanans as $pesanan)
                    <tr>
                        <td>{{ $pesanan->id }}</td>
                        <td>{{ $pesanan->user ? $pesanan->user->name : $pesanan->walkinCustomer->nama }}</td>
                        <td>{{ $pesanan->mitra->nama_toko }}</td>
                        <td>{{ $pesanan->jenis_pesanan }}</td>
                        <td>{{ $pesanan->tanggal_pesan }}</td>
                        <td>{{ $pesanan->status_pesanan ?? 'Menunggu' }}</td>
                        <td>
                            <a href="{{ route('superadmin.pesanan.show', $pesanan) }}" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection