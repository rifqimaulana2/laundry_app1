@extends('layouts.app')
@section('title', 'Tentang Kami - LaundryKuy')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-teal-50 via-blue-50 to-white py-16">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-teal-500 via-blue-500 to-indigo-600 bg-clip-text text-transparent mb-4 animate-fade-down">
            Tentang LaundryKuy
        </h1>
        <p class="text-lg md:text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed mb-8 animate-fade-up">
            LaundryKuy adalah startup laundry modern yang menghubungkan pelanggan dengan mitra laundry di Indramayu dan sekitarnya. 
            Kami menawarkan layanan kiloan, satuan, hingga express dengan sistem digital, antar-jemput gratis, serta peluang bisnis bagi mitra laundry.
        </p>

        <!-- Ilustrasi Icon -->
        <div class="flex justify-center mb-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-28 h-28 text-teal-500 animate-bounce-slow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                    d="M3 7h18M3 12h18M3 17h18M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
        </div>
    </div>
</section>

<!-- Visi & Misi Section -->
<section class="py-16 bg-gradient-to-br from-white via-blue-50 to-teal-50">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-12">Visi & Misi</h2>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-6 text-center">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.5 2 2 6.48 2 12s4.5 10 10 10 10-4.48 10-10S17.5 2 12 2zM7 10h10v2H7v-2zm0 4h7v2H7v-2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-teal-600 mb-2">Kemudahan</h3>
                <p class="text-gray-600">Memberikan kemudahan laundry bagi masyarakat dengan layanan antar-jemput modern.</p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-6 text-center">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14l4-4h12c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-blue-600 mb-2">Dukung Bisnis Lokal</h3>
                <p class="text-gray-600">Mendukung pertumbuhan bisnis laundry lokal dengan teknologi dan sistem digital.</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-6 text-center">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4a8 8 0 100 16 8 8 0 000-16zm1 11h-2v-2h2v2zm0-4h-2V7h2v4z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-indigo-600 mb-2">Cepat & Terpercaya</h3>
                <p class="text-gray-600">Menghadirkan layanan laundry cepat, bersih, dan terpercaya untuk semua pelanggan.</p>
            </div>
        </div>
    </div>
</section>
@endsection
