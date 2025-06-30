<!-- resources/views/pelanggan/lengkapi-profil.blade.php -->
@extends('layouts.app')

@section('title', 'Lengkapi Profil Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gradient-to-br from-teal-50 to-blue-100 min-h-screen">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-4 animate-fade-in">Profil Saya</h1>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto">Lengkapi informasi pribadi Anda untuk mendapatkan layanan terbaik.</p>
    </div>

    <section class="bg-white shadow-xl rounded-2xl p-8">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                {{ session('info') }}
            </div>
        @endif

        <form action="{{ route('pelanggan.simpan-profil') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <x-input-label for="nama" :value="__('Nama Lengkap')" />
                    <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" value="{{ old('nama', auth()->user()->pelangganProfile->nama ?? auth()->user()->name) }}" required autofocus />
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <x-input-label for="no_tlp" :value="__('Nomor Telepon / WhatsApp')" />
                    <x-text-input id="no_tlp" name="no_tlp" type="text" class="mt-1 block w-full" value="{{ old('no_tlp', auth()->user()->pelangganProfile->no_tlp ?? '') }}" required />
                    <x-input-error :messages="$errors->get('no_tlp')" class="mt-2" />
                </div>

                <!-- Kecamatan -->
                <div>
                    <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                    <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full" value="{{ old('kecamatan', auth()->user()->pelangganProfile->kecamatan ?? '') }}" required />
                    <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                </div>

                <!-- Foto Profil -->
                <div>
                    <x-input-label for="foto_profil" :value="__('Foto Profil')" />
                    <input type="file" name="foto_profil" id="foto_profil" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md" />
                    <x-input-error :messages="$errors->get('foto_profil')" class="mt-2" />
                    @if(auth()->user()->pelangganProfile && auth()->user()->pelangganProfile->foto_profil && auth()->user()->pelangganProfile->foto_profil !== 'default.jpg')
                        <p class="text-sm text-gray-600 mt-2">Foto saat ini: <a href="{{ asset('storage/pelanggan/foto/' . auth()->user()->pelangganProfile->foto_profil) }}" target="_blank" class="text-blue-600 hover:underline">{{ auth()->user()->pelangganProfile->foto_profil }}</a></p>
                    @endif
                </div>
            </div>

            <!-- Alamat -->
            <div class="mt-6">
                <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                <textarea id="alamat" name="alamat" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-900 focus:border-blue-900">{{ old('alamat', auth()->user()->pelangganProfile->alamat ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
            </div>

            <!-- Lokasi Otomatis -->
            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', auth()->user()->pelangganProfile->longitude ?? '') }}">
            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', auth()->user()->pelangganProfile->latitude ?? '') }}">
            <div class="mt-4">
                <button type="button" onclick="getLocation()" class="bg-blue-900 text-white px-7 py-3.5 rounded-lg hover:bg-blue-950 transition duration-200 shadow-xl">
                    Deteksi Lokasi Otomatis
                </button>
                <p id="lokasi-info" class="text-base text-black bg-white p-3.5 rounded-lg shadow-xl mt-3 border-4 border-blue-900">{{ old('lokasi_info', auth()->user()->pelangganProfile ? 'Lokasi: ' . (auth()->user()->pelangganProfile->latitude ?? 'Belum terdeteksi') . ', ' . (auth()->user()->pelangganProfile->longitude ?? 'Belum terdeteksi') : 'Lokasi belum terdeteksi') }}</p>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-900 text-white px-9 py-4 rounded-lg hover:bg-blue-950 transition duration-300 transform hover:scale-105 font-semibold shadow-2xl">
                    Simpan Profil
                </button>
            </div>
        </form>
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

<script>
    function getLocation() {
        const info = document.getElementById('lokasi-info');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    info.innerText = `Lokasi terdeteksi: ${position.coords.latitude}, ${position.coords.longitude}`;
                },
                function(error) {
                    info.innerText = 'Gagal mendeteksi lokasi: ' + error.message;
                }
            );
        } else {
            info.innerText = 'Browser Anda tidak mendukung geolokasi.';
        }
    }
</script>
@endsection