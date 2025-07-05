@extends('layouts.admin')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Data Pelanggan</h1>

    <form action="{{ route('superadmin.pelanggan.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $pelanggan->user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $pelanggan->user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="no_tlp">No. Telepon</label>
            <input type="text" name="no_tlp" class="form-control" value="{{ old('no_tlp', $pelanggan->no_tlp) }}">
        </div>

        <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $pelanggan->kecamatan) }}">
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $pelanggan->alamat) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('superadmin.pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
