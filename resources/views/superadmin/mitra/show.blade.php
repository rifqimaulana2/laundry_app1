@extends('layouts.admin')

@section('title', 'Detail Mitra')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Detail Mitra</h1>

    <div class="bg-white shadow p-6 rounded-lg space-y-4">
        <div><strong>Nama Toko:</strong> {{ $mitra->nama_toko }}</div>
        <div><strong>Alamat:</strong> {{ $mitra->alamat }}</div>
        <div><strong>No Telepon:</strong> {{ $mitra->no_telepon }}</div>
        <div><strong>Kecamatan:</strong> {{ $mitra->kecamatan }}</div>
        <div><strong>Status Approve:</strong> {{ $mitra->status_approve ? 'Disetujui' : 'Menunggu Verifikasi' }}</div>
        <div><strong>Status Langganan:</strong> {{ optional($mitra->langgananMitra)->status ?? 'Tidak Ada' }}</div>
    </div>

    <div class="mt-4">
        <a href="{{ route('superadmin.mitra.index') }}" class="text-blue-600 hover:underline">&larr; Kembali</a>
    </div>
</div>
@endsection
