@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-br from-teal-50 via-indigo-50 to-pink-50 py-20">
    <div class="max-w-7xl mx-auto px-6">

        {{-- HEADER --}}
        <div class="text-center mb-20">
            <h1 class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-blue-600 via-teal-500 to-indigo-600 bg-clip-text text-transparent leading-tight">
                Bergabung Menjadi Mitra Laundry
            </h1>
            <p class="mt-6 text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
                Kembangkan bisnis laundry Anda bersama <span class="font-semibold text-blue-700">LaundryKuy</span>! 
                Dapatkan dukungan promosi digital, teknologi modern, dan akses ke pelanggan setiap hari.
            </p>
            <a href="{{ url('/register') }}"
               class="inline-block mt-8 px-10 py-4 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all text-lg shadow-lg font-semibold">
                🚀 Daftar Sekarang
            </a>
        </div>

        {{-- SECTION: BENEFIT --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-24">
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-blue-700">✨ Keuntungan Menjadi Mitra</h2>
                <ul class="space-y-4 text-gray-700 text-base leading-relaxed">
                    <li class="flex items-start gap-2">
                        <span class="text-green-500 text-xl">✔</span> Promosi gratis melalui platform kami
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-500 text-xl">✔</span> Mendapatkan pelanggan baru setiap hari
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-500 text-xl">✔</span> Tanpa biaya pendaftaran
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-500 text-xl">✔</span> Sistem pemesanan & dukungan digital
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-500 text-xl">✔</span> Meningkatkan kepercayaan bisnis Anda
                    </li>
                </ul>
            </div>
            <div class="flex justify-center">
                <div class="w-full max-w-md rounded-2xl shadow-lg bg-white p-6 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-40 h-40 text-blue-600" 
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V9M15 17V5" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- SECTION: STATISTIK --}}
        <div class="bg-white p-12 rounded-2xl shadow-lg text-center mb-24">
            <h3 class="text-2xl font-bold text-blue-800 mb-4">📊 Sudah Banyak Laundry Bergabung</h3>
            <p class="text-gray-600 mb-8 max-w-xl mx-auto leading-relaxed">
                Tingkatkan pendapatan dan jangkauan pelanggan Anda bersama jaringan 
                <span class="font-semibold text-teal-600">mitra LaundryKuy</span> yang terus berkembang setiap hari.
            </p>
            <div class="flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="w-28 h-28 text-indigo-600 p-4 bg-indigo-100 rounded-2xl shadow-md" 
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V9M15 17V5" />
                </svg>
            </div>
        </div>

        {{-- SECTION: EXTRA BENEFIT --}}
        <div class="bg-white rounded-2xl shadow-lg p-10 mb-16">
            <h2 class="text-2xl font-bold text-pink-600 mb-6">🎁 Fasilitas Eksklusif untuk Mitra:</h2>
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 text-base">
                <li class="flex items-center gap-2"><span class="text-pink-500">✔</span> Promosi digital gratis untuk mitra baru</li>
                <li class="flex items-center gap-2"><span class="text-pink-500">✔</span> Akses pelanggan dari seluruh Indramayu & sekitarnya</li>
                <li class="flex items-center gap-2"><span class="text-pink-500">✔</span> Dashboard pemesanan & pelacakan pesanan online</li>
                <li class="flex items-center gap-2"><span class="text-pink-500">✔</span> Fasilitas antar-jemput terintegrasi</li>
                <li class="flex items-center gap-2"><span class="text-pink-500">✔</span> Dukungan pengembangan bisnis laundry berkelanjutan</li>
            </ul>
        </div>

        {{-- CTA --}}
        <div class="text-center">
            <a href="/" 
               class="bg-gradient-to-r from-pink-500 to-teal-500 text-white font-bold py-4 px-12 rounded-full shadow-lg hover:from-pink-600 hover:to-teal-600 transition duration-300 text-lg">
                🌟 Lihat Info LaundryKuy
            </a>
        </div>

    </div>
</section>
@endsection
