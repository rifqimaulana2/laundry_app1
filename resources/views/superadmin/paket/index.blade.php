@extends('layouts.admin')

@section('title', 'Paket Langganan')

@section('content')
<div class="container">
    <h1 class="mb-4">Paket Langganan</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Tambah Paket --}}
    <form action="{{ route('superadmin.paket.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Nama Paket</label>
                <input type="text" name="nama_paket" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>Durasi (bulan)</label>
                <input type="number" name="durasi" class="form-control" required>
            </div>
            <div class="form-group col-md-2 d-flex align-items-end">
                <button class="btn btn-success w-100">Tambah</button>
            </div>
        </div>
    </form>

    {{-- Tabel Daftar Paket --}}
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nama Paket</th>
                <th>Harga</th>
                <th>Durasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pakets as $paket)
            <tr>
                <td>{{ $paket->nama_paket }}</td>
                <td>Rp{{ number_format($paket->harga, 0, ',', '.') }}</td>
                <td>{{ $paket->durasi }} bulan</td>
                <td>
                    <form action="{{ route('superadmin.paket.destroy', $paket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                    {{-- (Opsional: tombol edit bisa ditambahkan di sini jika pakai view edit) --}}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada paket tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
