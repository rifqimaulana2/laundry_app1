@extends('layouts.app')
@section('title', 'Daftar Layanan - LaundryKuy')
@section('content')
<section class="bg-gradient-to-br from-teal-50 via-blue-50 to-white py-16">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Judul -->
        <h1 class="text-4xl md:text-5xl font-extrabold text-center bg-gradient-to-r from-teal-500 via-blue-500 to-indigo-600 bg-clip-text text-transparent mb-12">
            Daftar Layanan LaundryKuy
        </h1>

        <!-- Grid layanan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Laundry Kiloan -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl">📦</span>
                    <h2 class="text-2xl font-bold text-blue-700">Laundry Kiloan</h2>
                </div>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Cuci Reguler</li>
                    <li>Cuci Express</li>
                </ul>
            </div>

            <!-- Laundry Satuan -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center text-xl">👕</span>
                    <h2 class="text-2xl font-bold text-blue-700">Laundry Satuan</h2>
                </div>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Jaket</li>
                    <li>Boneka</li>
                    <li>Tas Sekolah</li>
                    <li>Sepatu</li>
                </ul>
            </div>

            <!-- Antar Jemput -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xl">🚚</span>
                    <h2 class="text-2xl font-bold text-blue-700">Antar-Jemput</h2>
                </div>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Gratis untuk semua pesanan</li>
                </ul>
            </div>

            <!-- Cuci Express -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center text-xl">⚡</span>
                    <h2 class="text-2xl font-bold text-blue-700">Cuci Express</h2>
                </div>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>1 Hari selesai (khusus area Indramayu)</li>
                </ul>
            </div>

        </div>
    </div>
</section>
@endsection
