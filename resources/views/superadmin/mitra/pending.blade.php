@extends('layouts.admin')

@section('title', 'Persetujuan Mitra')

@section('content')
<div class="container">
    <h1 class="mb-4">Mitra Menunggu Persetujuan</h1>

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
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mitras as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->no_telepon ?? '-' }}</td>
                <td>{{ $user->kecamatan ?? '-' }}</td>
                <td>
                    <form action="{{ route('superadmin.mitra.approve', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-success">Setujui</button>
                    </form>
                    <form action="{{ route('superadmin.mitra.reject', $user->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menolak mitra ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Tolak</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada mitra yang menunggu persetujuan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
