@extends('layouts.admin')

@section('title', 'Daftar Mitra')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Mitra Aktif</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Nama</th>
                <th>Nama Toko</th>
                <th>No. Telepon</th>
                <th>Kecamatan</th>
                <th>Status</th>
                <th>Langganan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mitras as $mitra)
            <tr>
                <td>{{ $mitra->nama }}</td>
                <td>{{ $mitra->nama_toko }}</td>
                <td>{{ $mitra->no_telepon }}</td>
                <td>{{ $mitra->kecamatan }}</td>
                <td>
                    {!! $mitra->status_approve 
                        ? '<span class="badge badge-success">Disetujui</span>' 
                        : '<span class="badge badge-warning">Pending</span>' !!}
                </td>
                <td>
                    {!! $mitra->langganan_aktif 
                        ? '<span class="badge badge-info">Aktif</span>' 
                        : '<span class="badge badge-secondary">Nonaktif</span>' !!}
                </td>
                <td>
                    <a href="{{ route('superadmin.mitra.edit', $mitra->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('superadmin.mitra.destroy', $mitra->id) }}" method="POST" class="d-inline" 
                          onsubmit="return confirm('Hapus mitra ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                    @if ($mitra->langganan_aktif)
                        <form action="{{ route('superadmin.mitra.deactivate', $mitra->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-warning">Nonaktifkan</button>
                        </form>
                    @else
                        <form action="{{ route('superadmin.mitra.approveMitra', $mitra->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-success">Aktifkan</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada mitra terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
