@extends('layouts.admin')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Pelanggan</h1>

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
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Kecamatan</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pelanggans as $pelanggan)
            <tr>
                <td>{{ $pelanggan->user->name }}</td>
                <td>{{ $pelanggan->user->email }}</td>
                <td>{{ $pelanggan->no_tlp ?? '-' }}</td>
                <td>{{ $pelanggan->kecamatan ?? '-' }}</td>
                <td>{{ $pelanggan->alamat ?? '-' }}</td>
                <td>
                    <a href="{{ route('superadmin.pelanggan.edit', $pelanggan->id) }}" class="btn btn-sm btn-primary">Edit</a>

                    <form action="{{ route('superadmin.pelanggan.destroy', $pelanggan->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data pelanggan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
