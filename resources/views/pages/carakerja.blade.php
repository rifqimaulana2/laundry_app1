@extends('layouts.app')
@section('title', 'Cara Kerja - LaundryKuy')

@section('content')
<section class="bg-gradient-to-br from-blue-50 via-teal-50 to-white py-16">
    <div class="max-w-5xl mx-auto px-6">
        <!-- Title -->
        <h1 class="text-4xl md:text-5xl font-extrabold text-center bg-gradient-to-r from-blue-500 via-teal-500 to-indigo-600 bg-clip-text text-transparent mb-12">
            Cara Kerja LaundryKuy
        </h1>

        <!-- Steps -->
        <div class="space-y-8 relative">
            <!-- Step 1 -->
            <div class="flex items-start gap-4 bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-teal-500 text-white shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-blue-600">Daftar / Login</h3>
                    <p class="text-gray-600">Pelanggan dan mitra mendaftar di website LaundryKuy untuk mulai menggunakan layanan.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="flex items-start gap-4 bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-r from-teal-500 to-indigo-500 text-white shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-teal-600">Pilih Layanan</h3>
                    <p class="text-gray-600">Pelanggan dapat memilih layanan laundry kiloan, satuan, atau express sesuai kebutuhan.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="flex items-start gap-4 bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-r from-indigo-500 to-blue-500 text-white shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-indigo-600">Isi Detail Pesanan</h3>
                    <p class="text-gray-600">Masukkan detail pesanan, alamat penjemputan, dan metode pembayaran.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="flex items-start gap-4 bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-r from-pink-500 to-red-500 text-white shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-pink-600">Antar - Jemput</h3>
                    <p class="text-gray-600">Kurir menjemput pakaian di alamat pelanggan dan mengantarkannya kembali setelah selesai.</p>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
@endsection
