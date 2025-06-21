@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-teal-50 to-white py-16">
    <div class="max-w-7xl mx-auto px-6">

        {{-- HEADER --}}
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-blue-900">Bergabung Menjadi Mitra Laundry</h1>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto text-lg">
                Kembangkan bisnis laundry Anda bersama kami! Dapatkan dukungan promosi, teknologi modern, dan akses ke lebih banyak pelanggan.
            </p>
            <a href="{{ url('/register') }}"
               class="inline-block mt-6 px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition text-lg shadow-lg font-semibold">
                Daftar Sekarang
            </a>
        </div>

        {{-- SECTION: BENEFIT --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-20">
            <div class="space-y-6">
                <h2 class="text-2xl font-semibold text-blue-700">Keuntungan Menjadi Mitra</h2>
                <ul class="space-y-3 text-gray-700 text-base leading-relaxed">
                    <li>✅ Promosi gratis melalui platform kami</li>
                    <li>✅ Mendapatkan pelanggan baru setiap hari</li>
                    <li>✅ Tanpa biaya pendaftaran</li>
                    <li>✅ Sistem pemesanan dan dukungan digital</li>
                    <li>✅ Meningkatkan kepercayaan terhadap bisnis Anda</li>
                </ul>
            </div>
            <div>
                <img src="{{ asset('images/laundry1.jpg') }}" alt="Ilustrasi Mitra Laundry"
                     class="w-full rounded-xl shadow-lg">
            </div>
        </div>

        {{-- SECTION: STATISTIK --}}
        <div class="bg-white p-10 rounded-xl shadow-md text-center">
            <h3 class="text-2xl font-semibold text-blue-800 mb-4">Sudah Banyak Laundry Bergabung Bersama Kami</h3>
            <p class="text-gray-600 mb-6 max-w-xl mx-auto">
                Tingkatkan pendapatan dan jangkauan pelanggan Anda bersama jaringan mitra kami.
            </p>
            <img src="{{ asset('images/mitra-statistic.jpg') }}" alt="Statistik Mitra"
                 class="mx-auto rounded-lg w-full max-w-xl">
        </div>
    </div>
</section>
@endsection
