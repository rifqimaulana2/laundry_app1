@extends('layouts.app')
@section('title', 'Home - LaundryKuy')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
    }
    .accordion-content.active {
        max-height: 1000px; /* Nilai awal besar, akan disesuaikan oleh JS */
    }
    .accordion-toggle svg {
        transition: transform 0.3s ease;
    }
    .accordion-toggle.active svg {
        transform: rotate(180deg);
    }
    .mitra-card {
        background: linear-gradient(135deg, #f0fdfa, #e0f2fe); /* Gradien teal ke biru muda */
        border: 1px solid #99ebeb; /* Border teal lembut */
        border-radius: 0.5rem;
        padding: 0.75rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .mitra-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .mitra-card img {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #2dd4bf; /* Teal-400 */
        object-fit: cover;
    }
    .mitra-card h4 {
        font-size: 0.875rem;
        color: #164e63; /* Biru tua lembut */
        margin: 0.25rem 0;
    }
    .mitra-card p {
        font-size: 0.625rem;
        color: #64748b;
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100px;
    }
</style>
@endpush

@section('content')

{{-- HERO SECTION --}}
<section class="bg-gradient-to-br from-blue-50 to-blue-100 py-8 sm:py-10 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-10">
        <div class="lg:w-1/2 text-left">
            <span class="text-xs font-semibold text-teal-600 uppercase tracking-wide block mb-2">
                WE ARE LAUNDRYKUY
            </span>
            <h1 class="text-4xl font-extrabold text-blue-800 leading-tight mb-5">
                Solusi Laundry Modern<br>
                Cepat, Bersih, & Antar-Jemput
            </h1>
            <p class="text-gray-700 text-base sm:text-lg leading-relaxed mb-6">
                Nikmati kemudahan laundry dari rumah. Pilih layanan kiloan atau satuan, kurir kami siap menjemput pesanan Anda!
            </p>
            <a href="/login"
                class="inline-flex items-center bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300">
                Pesan Sekarang
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        <div class="lg:w-1/2 flex justify-center">
            <img src="{{ asset('images/laundry1.jpg') }}" alt="Ilustrasi layanan laundry modern"
                class="max-w-full sm:max-w-md md:max-w-lg lg:max-w-xl h-auto rounded-xl shadow-lg object-contain max-h-full">
        </div>
    </div>
</section>

{{-- LAYANAN KAMI --}}
<section class="py-8 bg-gradient-to-br from-teal-50 to-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-teal-600 mb-6">Layanan Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Laundry Satuan -->
            <div class="bg-white rounded-xl shadow-sm p-5 flex flex-col justify-between">
                <div class="flex flex-col items-center text-center">
                    <img src="{{ asset('images/laundry_satuan.png') }}" alt="Laundry Satuan" class="h-20 mb-3">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">Laundry Satuan</h3>
                    <ul class="text-sm text-gray-700 list-disc list-inside mb-4 text-left w-full">
                        <li>Jaket</li>
                        <li>boneka kecil</li>
                        <li>Tas Sekolah</li>
                        <li>Sepatu Putih</li>
                        <li>Sepatu berwarna</li>
                    </ul>
                </div>
                <div class="text-center">
                    <a href="/register" class="bg-teal-500 text-white text-sm px-4 py-2 rounded-md hover:bg-teal-600 transition">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
            <!-- Laundry Kiloan -->
            <div class="bg-white rounded-xl shadow-sm p-5 flex flex-col justify-between">
                <div class="flex flex-col items-center text-center">
                    <img src="{{ asset('images/laundry_kiloan.png') }}" alt="Laundry Kiloan" class="h-20 mb-3">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">Laundry Kiloan</h3>
                    <ul class="text-sm text-gray-700 list-disc list-inside mb-4 text-left w-full">
                        <li>Cuci Express</li>
                        <li>Cuci Reguler</li>
                    </ul>
                </div>
                <div class="text-center">
                    <a href="/register" class="bg-teal-500 text-white text-sm px-4 py-2 rounded-md hover:bg-teal-600 transition">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row items-center justify-between bg-gradient-to-r from-teal-100 to-blue-50 border border-teal-200 rounded-3xl p-6 shadow-sm">
            <div class="md:w-1/3 mb-6 md:mb-0">
                <img src="{{ asset('images/antar_jemput.png') }}" alt="Gratis Antar Jemput" class="mx-auto h-28">
            </div>
            <div class="md:w-2/3 text-center md:text-left">
                <h3 class="text-2xl font-bold text-teal-600 mb-3">Gratis Antar Jemput</h3>
                <p class="text-gray-700 text-base leading-relaxed">
                    Semua layanan kami dilengkapi dengan fasilitas <strong>antar jemput pakaian langsung ke rumah Anda</strong>, tanpa biaya tambahan. Praktis, hemat waktu, dan tanpa repot!
                </p>
            </div>
        </div>
    </div>
</section>

{{-- PELACAKAN PESANAN --}}
<section class="py-8 bg-gradient-to-br from-teal-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-teal-600 mb-4">Pelacakan Pesanan</h2>
        <p class="text-base sm:text-lg text-gray-700 mb-6 max-w-xl mx-auto">
            Lacak status pesanan Anda secara real-time dengan mudah.
        </p>
        <form action="/pelacakan" method="GET" class="max-w-md mx-auto">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="kode" required minlength="5" placeholder="Masukkan kode pesanan"
                    class="w-full border border-gray-300 rounded-md shadow-sm p-3 text-sm sm:text-base focus:ring-teal-400 focus:border-teal-400 bg-white" />
                <button type="submit"
                    class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-5 rounded-lg transition-colors text-sm sm:text-base">
                    Lacak
                </button>
            </div>
        </form>
    </div>
</section>

<section class="bg-gradient-to-b from-teal-50 to-blue-100 py-12" x-data="{ selectedKecamatan: 'Indramayu' }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-blue-900 mb-4">Mitra Berdasarkan Kecamatan</h2>
        <p class="text-center text-gray-700 mb-8 max-w-2xl mx-auto">
            Pilih kecamatan untuk melihat beberapa mitra yang tersedia
        </p>

        <!-- Dropdown Kecamatan -->
        <div class="flex justify-center mb-10">
            <select x-model="selectedKecamatan" class="bg-white border border-gray-300 rounded-xl px-5 py-2 text-gray-800 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="Indramayu">Indramayu</option>
                <option value="Sindang">Sindang</option>
                <option value="Lohbener">Lohbener</option>
            </select>
        </div>

        @php
            $dataMitra = [
                'Indramayu' => [
                    ['nama' => "Kilo's Laundry", 'alamat' => 'Jl. Jend. Sudirman, Indramayu', 'gambar' => 'laundry1.jpg', 'telepon' => '0812-3456-7890'],
                    ['nama' => 'Tomodachi Laundry', 'alamat' => 'Jl. Jend. Sudirman No.144, Lemahmekar, Indramayu', 'gambar' => 'laundry2.jpg', 'telepon' => '0813-9876-5432'],
                    ['nama' => 'Omeh Laundry', 'alamat' => 'Wisma An Nur Ruko No. 1, Karangmalang, Indramayu', 'gambar' => 'laundry3.jpg', 'telepon' => '0821-2233-4455'],
                ],
                'Sindang' => [
                    ['nama' => 'Bebasuh Coin Laundry', 'alamat' => 'Jl. Dharma Ayu, Dermayu, Sindang', 'gambar' => 'laundry4.jpg', 'telepon' => '0812-1000-2000'],
                    ['nama' => "Kino Laundry", 'alamat' => 'Jl. Cimanuk Barat No. 32, Sindang', 'gambar' => 'laundry5.jpg', 'telepon' => '0812-3344-5566'],
                    ['nama' => "Kilo's Laundry", 'alamat' => 'Jl. Cimanuk Barat No. 2, Sindang', 'gambar' => 'laundry6.jpg', 'telepon' => '0812-5566-7788'],
                    ['nama' => 'Shayn Laundry', 'alamat' => 'Samping STIKES, Jl. Wirapati, Sindang', 'gambar' => 'laundry7.jpg', 'telepon' => '0813-1234-5678'],
                ],
                'Lohbener' => [
                    ['nama' => 'Laundry Ibu Ilah', 'alamat' => 'Blok Cangkring, Lohbener', 'gambar' => 'laundry8.jpg', 'telepon' => '0813-7777-8888'],
                    ['nama' => 'Amanah Laundry', 'alamat' => 'Blok Bangkir Kunir, Lohbener', 'gambar' => 'laundry9.jpg', 'telepon' => '0812-6666-5555'],
                    ['nama' => 'Awan Laundry', 'alamat' => 'Jl. Raya Lohbener', 'gambar' => 'laundry10.jpg', 'telepon' => '0812-8888-9999'],
                ]
            ];
        @endphp

        <!-- Grid Mitra Scrollable -->
        <template x-for="(mitras, kecamatan) in {{ Js::from($dataMitra) }}" :key="kecamatan">
            <div x-show="selectedKecamatan === kecamatan" class="overflow-x-auto">
                <div class="flex space-x-4 snap-x snap-mandatory max-w-[900px] mx-auto overflow-x-auto px-1">
                    <template x-for="mitra in mitras" :key="mitra.nama">
                        <div class="min-w-[260px] max-w-[260px] h-[340px] flex-shrink-0 bg-white rounded-xl shadow-md p-4 text-center space-y-2 snap-start transition hover:shadow-lg">
                            <img :src="'/images/' + mitra.gambar" :alt="'Foto ' + mitra.nama" class="w-16 h-16 object-cover rounded-full mx-auto border border-teal-400">
                            <h3 class="text-base font-semibold text-blue-800" x-text="mitra.nama"></h3>
                            <p class="text-sm text-gray-600 line-clamp-3 h-[42px]" x-text="mitra.alamat"></p>
                            <p class="text-sm text-gray-500" x-text="'Telp: ' + mitra.telepon"></p>
                            <a href="{{ url('/register') }}" class="inline-block mt-2 bg-teal-500 text-white px-3 py-1.5 rounded-full text-xs hover:bg-teal-600">
                                Lihat Detail
                            </a>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</section>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper('.swiper-beforeafter', {
        slidesPerView: 1.2,
        spaceBetween: 20,
        grabCursor: true,
        breakpoints: {
            640: { slidesPerView: 2.2 },
            1024: { slidesPerView: 3 },
        }
    });

    new Swiper('.swiper-mitra', {
        slidesPerView: 1.2,
        spaceBetween: 16,
        loop: true,
        autoplay: { delay: 3000 },
        breakpoints: {
            640: { slidesPerView: 2.5 },
            1024: { slidesPerView: 3.5 },
        }
    });

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
    });
</script>
@endpush
@endsection