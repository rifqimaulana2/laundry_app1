@extends('layouts.mitra')
@section('title', 'Profil Toko')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded-lg">
    <h2 class="text-xl font-bold mb-4">Profil Toko</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <div class="mb-4"><strong>Nama Toko:</strong> {{ $profil->nama_toko }}</div>
    <div class="mb-4"><strong>Alamat:</strong> {{ $profil->alamat }}</div>
    <div class="mb-4"><strong>No HP:</strong> {{ $profil->no_telepon }}</div>
    <div class="mb-4"><strong>Latitude:</strong> {{ $profil->latitude ?? '-' }}</div>
    <div class="mb-4"><strong>Longitude:</strong> {{ $profil->longitude ?? '-' }}</div>
    <div class="mb-4"><strong>Status Approve:</strong>
        @if(auth()->user()->status_approve)
            <span class="text-green-600 font-semibold">Disetujui</span>
        @else
            <span class="text-yellow-600 font-semibold">Menunggu Persetujuan</span>
        @endif
    </div>

    <a href="{{ route('mitra.profil.edit') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Edit Profil</a>
</div>
@endsection
