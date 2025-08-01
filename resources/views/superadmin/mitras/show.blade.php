@extends('superadmin.approval')

@section('title', 'Detail Mitra')

@section('content')
    <h2>Detail Mitra</h2>
    <table class="table table-bordered">
        <tr><th>Nama Toko</th><td>{{ $mitra->nama_toko }}</td></tr>
        <tr><th>Kecamatan</th><td>{{ $mitra->kecamatan }}</td></tr>
        <tr><th>Alamat</th><td>{{ $mitra->alamat_lengkap }}</td></tr>
        <tr><th>No. Telepon</th><td>{{ $mitra->no_telepon }}</td></tr>
        <tr><th>Status</th><td><span class="badge bg-secondary">{{ $mitra->status_approve }}</span></td></tr>
        <tr><th>Latitude</th><td>{{ $mitra->latitude }}</td></tr>
        <tr><th>Longitude</th><td>{{ $mitra->longitude }}</td></tr>
        <tr><th>Foto Toko</th><td><img src="{{ asset('storage/'.$mitra->foto_toko) }}" width="100"></td></tr>
        <tr><th>Foto Profil</th><td><img src="{{ asset('storage/'.$mitra->foto_profile) }}" width="100"></td></tr>
    </table>
    <a href="{{ route('superadmin.mitras.index') }}" class="btn btn-primary">Kembali</a>
@endsection
