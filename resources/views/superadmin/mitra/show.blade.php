@extends('layouts.admin')

@section('title', 'Detail Mitra')

@section('content')
<div class="container">
    <h1 class="mb-4">Detail Mitra</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $mitra->nama_toko }}</h5>
            <p class="card-text"><strong>Nama Pemilik:</strong> {{ $mitra->nama }}</p>
            <p class="card-text"><strong>No. Telepon:</strong> {{ $mitra->no_telepon ?? '-' }}</p>
            <p class="card-text"><strong>Alamat:</strong> {{ $mitra->alamat }}</p>
            <p class="card-text"><strong>Kecamatan:</strong> {{ $mitra->kecamatan }}</p>
            <p class="card-text"><strong>Longitude:</strong> {{ $mitra->longitude }}</p>
            <p class="card-text"><strong>Latitude:</strong> {{ $mitra->latitude }}</p>
            <p class="card-text">
                <strong>Status Approve:</strong>
                {!! $mitra->status_approve ? '<span class="badge badge-success">Disetujui</span>' : '<span class="badge badge-warning">Pending</span>' !!}
            </p>
            <p class="card-text">
                <strong>Langganan Aktif:</strong>
                {!! $mitra->langganan_aktif ? '<span class="badge badge-info">Aktif</span>' : '<span class="badge badge-secondary">Nonaktif</span>' !!}
            </p>
        </div>
    </div>

    <a href="{{ route('superadmin.mitra.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
