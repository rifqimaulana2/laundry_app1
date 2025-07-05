@extends('layouts.mitra')

@section('title', 'Profil Mitra')

@section('content')
<h1 class="text-xl font-semibold mb-4">Profil Saya</h1>

<div class="bg-white p-4 shadow rounded">
    <p><strong>Nama:</strong> {{ $mitra->nama }}</p>
    <p><strong>Nama Toko:</strong> {{ $mitra->nama_toko }}</p>
    <p><strong>Alamat:</strong> {{ $mitra->alamat }}</p>
    <p><strong>No Telepon:</strong> {{ $mitra->no_telepon }}</p>
    <p><strong>Kecamatan:</strong> {{ $mitra->kecamatan }}</p>
    <p><strong>Lokasi:</strong> {{ $mitra->latitude }}, {{ $mitra->longitude }}</p>

    <a href="{{ route('mitra.profil.edit') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded shadow">Edit Profil</a>
</div>
@endsection
