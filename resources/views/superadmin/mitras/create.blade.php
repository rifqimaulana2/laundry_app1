<!-- resources/views/superadmin/mitras/create.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="container">
        <h1>Tambah Mitra</h1>
        <form action="{{ route('superadmin.mitras.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Pemilik (User)</label>
                <select name="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nama Tokoo</label>
                <input type="text" name="nama_toko" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat_lengkap" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Longitude</label>
                <input type="text" name="longitude" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Latitude</label>
                <input type="text" name="latitude" class="form-control" required>
            </div>
            <div class="form-group">
                <label>No Telepon</label>
                <input type="text" name="no_telepon" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Foto Toko</label>
                <input type="file" name="foto_toko" class="form-control">
            </div>
            <div class="form-group">
                <label>Foto Profil</label>
                <input type="file" name="foto_profile" class="form-control">
            </div>
            <div class="form-group">
                <label>Status Approve</label>
                <select name="status_approve" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection