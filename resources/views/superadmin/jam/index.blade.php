@extends('layouts.admin')

@section('title', 'Jam Operasional Mitra')

@section('content')
<div class="container">
    <h1 class="mb-4">Jam Operasional Mitra</h1>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Nama Toko</th>
                <th>Hari</th>
                <th>Jam Buka</th>
                <th>Jam Tutup</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jams as $jam)
            <tr>
                <td>{{ $jam->mitra->nama_toko ?? '-' }}</td>
                <td>{{ $jam->hari_buka }}</td>
                <td>{{ $jam->jam_buka }}</td>
                <td>{{ $jam->jam_tutup }}</td>
                <td>
                    <a href="{{ route('superadmin.jam.edit', $jam->id) }}" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data jam operasional.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
