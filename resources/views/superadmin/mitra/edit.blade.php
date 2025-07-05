@extends('layouts.admin')

@section('title', 'Edit Mitra')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Data Mitra</h1>

    <form action="{{ route('superadmin.mitra.update', $mitra->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama">Nama Pemilik</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $mitra->nama) }}" required>
        </div>

        <div class="form-group">
            <label for="nama_toko">Nama Toko</label>
            <input type="text" name="nama_toko" class="form-control" value="{{ old('nama_toko', $mitra->nama_toko) }}" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $mitra->alamat) }}</textarea>
        </div>

        <div class="form-group">
            <label for="no_telepon">No. Telepon</label>
            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $mitra->no_telepon) }}">
        </div>

        <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $mitra->kecamatan) }}">
        </div>

        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $mitra->longitude) }}">
        </div>

        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $mitra->latitude) }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('superadmin.mitra.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
