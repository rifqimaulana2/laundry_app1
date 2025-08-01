@extends('layouts.app')
@section('title', 'Home - LaundryKuy')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        background: #E6E6FA !important;
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    html {
        background: #E6E6FA !important;
    }
    /* Modern font */
    body, h1, h2, h3, p, a {
        font-family: 'Poppins', sans-serif;
    }
    /* Optimized accordion styles */
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
    }
    .accordion-content.active {
        max-height: 1000px; /* Adjusted for dynamic content */
    }
    .accordion-toggle svg {
        transition: transform 0.3s ease;
    }
    .accordion-toggle.active svg {
        transform: rotate(180deg);
    }
    .card-shadow {
        border-radius: 1.25rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        background-color: #FFFFFF; /* Bright White */
        padding: 1.5rem;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .card-shadow:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transform: translateY(-4px);
    }
    /* Promo Pop-up */
    .promo-popup {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: linear-gradient(135deg, #1D4ED8, #A5F3FC); /* Deep Blue to Light Aqua */
        color: #FFFFFF;
        padding: 1.5rem;
        border-radius: 1.25rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        display: none;
        max-width: 300px;
    }
    .promo-popup.active {
        display: block;
    }
    /* Animated CTA Button */
    .cta-button {
        transition: transform 0.2s ease, background 0.3s ease, box-shadow 0.3s ease;
        border-radius: 0.75rem;
    }
    .cta-button:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
</style>
@endpush

@section('content')
<!-- SEO Meta Tags -->
<meta name="description" content="LaundryKuy - Solusi laundry modern dengan antar-jemput gratis. Daftar sekarang untuk kemudahan mencuci pakaian!">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-600 via-cyan-100 to-white py-16 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 flex flex-col lg:flex-row items-center gap-10">
        <div class="lg:w-1/2 text-left">
            <span class="text-xs font-bold text-coral-500 uppercase tracking-wide block mb-2">
                LAUNDRYKUY STARTUP
            </span>
            <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-400 leading-tight mb-5">
                Laundry Praktis dengan LaundryKuy
            </h1>
            <p class="text-gray-800 text-lg leading-relaxed mb-6">
                Atur laundry Anda dengan mudah melalui aplikasi kami. <br>
                <span class="font-semibold text-blue-600">Daftar sekarang untuk layanan antar-jemput gratis!</span>
            </p>
            <div class="flex gap-4 mb-4">
                <a href="/register" class="inline-flex items-center bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg cta-button hover:bg-blue-700">
                    Daftar Pelanggan
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="/jadimitra" class="inline-flex items-center bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg cta-button hover:bg-blue-700">
                    Daftar Mitra
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="mt-2 text-sm text-gray-600">Sudah punya akun? <a href="/login" class="text-blue-600 font-semibold hover:underline">Login di sini</a></div>
        </div>
        <div class="lg:w-1/2 flex justify-center">
            <img src="{{ asset('images/laundry1.jpg') }}" alt="Ilustrasi pakaian bersih dengan layanan LaundryKuy"
                class="max-w-xl h-auto rounded-xl shadow-2xl object-contain border-4 border-cyan-200">
        </div>
    </div>
</section>

<!-- Layanan Kami -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-10">Layanan Kami</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="card-shadow text-center">
                <img src="{{ asset('images/laundry_satuan.png') }}" alt="Ikon layanan laundry satuan" class="h-20 mb-4 mx-auto" />
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Laundry Satuan</h3>
                <ul class="text-sm text-gray-600 list-disc list-inside mb-4 text-left">
                    <li>Sepatu</li><li>Boneka</li><li>Sweater</li><li>Bed Cover</li><li>Jaket</li><li>Tas</li>
                </ul>
                <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition cta-button">Pesan Sekarang</a>
            </div>
            <div class="card-shadow text-center">
                <img src="{{ asset('images/laundry_kiloan.png') }}" alt="Ikon layanan laundry kiloan" class="h-20 mb-4 mx-auto" />
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Laundry Kiloan</h3>
                <ul class="text-sm text-gray-600 list-disc list-inside mb-4 text-left">
                    <li>Cuci Express</li><li>Cuci Reguler</li>
                </ul>
                <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition cta-button">Pesan Sekarang</a>
            </div>
        </div>
    </div>
</section>

<!-- Mengapa Memilih LaundryKuy -->
<section class="py-12 bg-cyan-50">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-blue-700 mb-8">Mengapa Memilih LaundryKuy?</h2>
        <p class="text-gray-800 text-lg mb-6">Nikmati kemudahan mencuci pakaian dengan layanan antar-jemput gratis dan pilihan cuci express atau reguler. Daftar sekarang untuk pengalaman laundry yang praktis!</p>
        <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg cta-button">Coba Sekarang</a>
    </div>
</section>

<!-- Testimoni Pelanggan -->
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-10">Apa Kata Pelanggan Kami</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach ([1 => 'Rina, Indramayu', 2 => 'Dimas, Lohbener', 3 => 'Sari, Sindang'] as $i => $name)
            <div class="card-shadow text-center">
                <img src="{{ asset("images/testi$i.jpg") }}" alt="Foto profil pelanggan {{ $name }}" class="w-16 h-16 rounded-full object-cover mx-auto mb-3">
                <p class="text-gray-600 text-sm italic mb-2">"{{ ['Pelayanan cepat, hasil cucian bersih dan wangi. Kurirnya ramah!', 'LaundryKuy bikin hidup lebih mudah, cucian selalu rapi!', 'Cuci express beneran cepat, cocok buat yang buru-buru!'][$i-1] }}"</p>
                <span class="text-blue-600 text-xs font-semibold">{{ $name }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-cyan-50">
    <div class="max-w-5xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="card-shadow flex flex-col items-center">
                <h2 class="text-2xl font-bold text-coral-500 mb-3">Jadi Mitra LaundryKuy</h2>
                <p class="text-gray-800 text-center mb-4">Kembangkan bisnis laundry Anda dengan sistem digital dan akses pelanggan luas.</p>
                <a href="/register" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg cta-button hover:bg-blue-700">Gabung Jadi Mitra</a>
            </div>
            <div class="card-shadow flex flex-col items-center">
                <h2 class="text-2xl font-bold text-blue-600 mb-3">Jadi Pelanggan LaundryKuy</h2>
                <p class="text-gray-800 text-center mb-4">Atur laundry Anda dengan mudah dan nikmati layanan antar-jemput gratis.</p>
                <a href="/register" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg cta-button hover:bg-blue-700">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</section>

<!-- Promo Banner -->
<section class="py-8 bg-blue-600 text-white text-center">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-2">Mulai Laundry Praktis Sekarang!</h2>
        <p class="mb-4">Daftar sekarang untuk layanan laundry dengan antar-jemput gratis.</p>
        <a href="/register" class="bg-coral-500 text-white font-bold py-3 px-8 rounded-lg shadow-lg cta-button hover:bg-coral-600">Coba Sekarang!</a>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Improved Accordion Script
    document.addEventListener('DOMContentLoaded', () => {
        const toggles = document.querySelectorAll('.accordion-toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const content = toggle.nextElementSibling;
                const isActive = content.classList.contains('active');

                document.querySelectorAll('.accordion-content').forEach(item => {
                    item.classList.remove('active');
                    item.style.maxHeight = '0';
                    item.previousElementSibling.classList.remove('active');
                });

                if (!isActive) {
                    content.classList.add('active');
                    toggle.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
            });
        });

        // Promo Pop-up
        setTimeout(() => {
            document.getElementById('promoPopup').classList.add('active');
        }, 3000);
    });
</script>
@endpush
@endsection