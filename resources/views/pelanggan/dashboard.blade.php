@extends('layouts.pelanggan')

@section('content')
<div class="bg-gradient-to-br from-indigo-100 via-white to-purple-100 min-h-screen px-6 py-16 flex items-center justify-center">
    <div class="max-w-7xl w-full space-y-16">

        {{-- Hero Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Left Side --}}
            <div class="text-center lg:text-left space-y-6">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-800 leading-tight">
                    👋 Hai, {{ Auth::user()->name }}
                </h1>
                <p class="text-xl text-gray-600 max-w-lg mx-auto lg:mx-0">
                    Selamat datang kembali di <span class="font-semibold text-indigo-600">LaundryKuy</span> ✨  
                    Yuk nikmati layanan laundry terbaik, cepat, bersih, dan wangi!
                </p>

                {{-- CTA --}}
                <div class="pt-4">
                    <a href="{{ route('pelanggan.mitra.index') }}"
                       class="inline-flex items-center gap-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-4 rounded-2xl text-lg font-semibold shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-300">
                        🔍 Cari Mitra Sekarang
                    </a>
                </div>
            </div>

            {{-- Right Side - Illustration --}}
            <div class="relative flex justify-center lg:justify-end">
                {{-- Background Accent --}}
                <div class="absolute -top-10 -right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-pulse"></div>
                <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-pulse"></div>

                {{-- Laundry Illustration --}}
                <img src="https://cdn-icons-png.flaticon.com/512/1047/1047711.png" 
                     alt="Laundry Illustration" 
                     class="relative w-80 h-80 object-contain drop-shadow-lg">
            </div>
        </div>

        {{-- Feature Section --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 text-center">
            <div class="bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition transform hover:-translate-y-2">
                <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mb-4 text-2xl">⚡</div>
                <h3 class="text-lg font-semibold text-gray-800">Cepat & Tepat Waktu</h3>
                <p class="mt-2 text-gray-500 text-sm">Pesananmu selalu diproses dengan cepat tanpa mengurangi kualitas.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition transform hover:-translate-y-2">
                <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-purple-100 text-purple-600 mb-4 text-2xl">🌿</div>
                <h3 class="text-lg font-semibold text-gray-800">Bersih & Wangi</h3>
                <p class="mt-2 text-gray-500 text-sm">Gunakan deterjen ramah lingkungan, hasil cucian wangi segar.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition transform hover:-translate-y-2">
                <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-pink-100 text-pink-600 mb-4 text-2xl">🤝</div>
                <h3 class="text-lg font-semibold text-gray-800">Mitra Terpercaya</h3>
                <p class="mt-2 text-gray-500 text-sm">Semua mitra sudah melalui verifikasi agar kamu lebih tenang.</p>
            </div>
        </div>

    </div>
</div>
@endsection
