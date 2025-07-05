@extends('layouts.admin')

@section('title', 'Edit Jam Operasional')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Jam Operasional</h1>

    <form action="{{ route('superadmin.jam.update', $jam->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="hari_buka">Hari</label>
            <input type="text" name="hari_buka" class="form-control" value="{{ old('hari_buka', $jam->hari_buka) }}" required>
        </div>

        <div class="form-group">
            <label for="jam_buka">Jam Buka</label>
            <input type="time" name="jam_buka" class="form-control" value="{{ old('jam_buka', $jam->jam_buka) }}" required>
        </div>

        <div class="form-group">
            <label for="jam_tutup">Jam Tutup</label>
            <input type="time" name="jam_tutup" class="form-control" value="{{ old('jam_tutup', $jam->jam_tutup) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('superadmin.jam.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
