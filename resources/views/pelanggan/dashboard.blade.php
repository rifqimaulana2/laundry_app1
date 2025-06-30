@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gradient-to-br from-teal-50 to-blue-100 min-h-screen">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-4 animate-fade-in">Dashboard Pelanggan</h1>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>

    <section class="bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-semibold text-blue-800 mb-6">Profil Anda</h2>
        <p><strong>Nama:</strong> {{ $profile->nama }}</p>
        <p><strong>Telepon:</strong> {{ $profile->no_tlp }}</p>
        <p><strong>Alamat:</strong> {{ $profile->alamat }}</p>
        <p><strong>Kecamatan:</strong> {{ $profile->kecamatan }}</p>
        <p><strong>Lokasi:</strong> ({{ $profile->latitude }}, {{ $profile->longitude }})</p>
        @if($profile->foto_profil)
            <p><strong>Foto Profil:</strong> <a href="{{ asset('storage/pelanggan/foto/' . $profile->foto_profil) }}" target="_blank">Lihat Foto</a></p>
        @endif

        <h2 class="text-2xl font-semibold text-blue-800 mt-8 mb-4">Mitra Terdekat</h2>
        @if(count($mitras) > 0)
            <ul>
                @foreach($mitras as $mitra)
                    <li>{{ $mitra->nama_toko }} - {{ $mitra->alamat }} (Jarak: TBD)</li>
                @endforeach
            </ul>
        @else
            <p>Tidak ada mitra terdekat saat ini.</p>
        @endif
    </section>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endsection