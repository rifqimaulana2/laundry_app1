@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Notifikasi</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Untuk</th>
                <th>Pesan</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($notifikasis as $notif)
            <tr>
                <td>{{ $notif->user->name ?? '-' }}</td>
                <td>{{ $notif->pesan }}</td>
                <td>
                    {!! $notif->status_baca 
                        ? '<span class="badge badge-success">Dibaca</span>' 
                        : '<span class="badge badge-warning">Belum Dibaca</span>' !!}
                </td>
                    <td>{{ $notif->created_at->format('d M Y H:i') }}</td>
                <td>
                    @if (!$notif->status_baca)
                    <form action="{{ route('superadmin.notifikasi.markAsRead', $notif->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-info">Tandai Dibaca</button>
                    </form>
                    @endif
                    <form action="{{ route('superadmin.notifikasi.destroy', $notif->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus notifikasi ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada notifikasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
