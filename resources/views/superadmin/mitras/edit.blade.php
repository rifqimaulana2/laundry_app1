<!-- resources/views/superadmin/mitras/edit.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="container">
        <h1>Edit Mitra</h1>
        <form action="{{ route('superadmin.mitras.update', $mitra) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Pemilik (User)</label>
                <select name="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $mitra->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nama Toko</label>
                <input type="text" name="nama_toko" value="{{ $mitra->nama_toko }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ $mitra->kecamatan }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat_lengkap" class="form-control" required>{{ $mitra->alamat_lengkap }}</textarea>
            </div>
            <div class="form-group">
                <label>Longitude</label>
                <input type="text" name="longitude" value="{{ $mitra->longitude }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Latitude</label>
                <input type="text" name="latitude" value="{{ $mitra->latitude }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>No Telepon</label>
                <input type="text" name="no_telepon" value="{{ $mitra->no_telepon }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Foto Toko</label>
                <input type="file" name="foto_toko" class="form-control">
                @if ($mitra->foto_toko)
                    <img src="{{ asset('storage/' . $mitra->foto_toko) }}" width="100" class="mt-2">
                @endif
            </div>
            <div class="form-group">
                <label>Foto Profil</label>
                <input type="file" name="foto_profile" class="form-control">
                @if ($mitra->foto_profile)
                    <img src="{{ asset('storage/' . $mitra->foto_profile) }}" width="100" class="mt-2">
                @endif
            </div>
            <div class="form-group">
                <label>Status Approve</label>
                <select name="status_approve" class="form-control" required>
                    <option value="pending" {{ $mitra->status_approve == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ $mitra->status_approve == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ $mitra->status_approve == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection