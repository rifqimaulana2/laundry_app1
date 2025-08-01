@extends('layouts.mitra')

@section('content')
<!-- Navbar Mitra -->
<nav class="flex items-center justify-between px-4 py-4 bg-white rounded-2xl shadow mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Mitra</h1>
    <div class="flex items-center gap-3">
        <i data-lucide="store" class="w-6 h-6 text-green-600"></i>
        <span class="text-lg font-semibold text-gray-700">
            {{ $mitra->nama_toko ?? (auth()->user()->mitra->nama_toko ?? 'Mitra') }}
        </span>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 py-6 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pesanan -->
        <div class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-cyan-600 text-white rounded-full shadow-md">
                    <i data-lucide="shopping-bag" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Total Pesanan</h2>
                    <p class="text-4xl font-bold text-cyan-600">{{ $totalPesanans }}</p>
                    <p class="text-sm text-gray-500 mt-1">Jumlah pesanan masuk</p>
                </div>
            </div>
        </div>

        <!-- Tagihan Belum Lunas -->
        <div class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-red-600 text-white rounded-full shadow-md">
                    <i data-lucide="alert-circle" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Tagihan Belum Lunas</h2>
                    <p class="text-4xl font-bold text-red-600">{{ $totalTagihans }}</p>
                    <p class="text-sm text-gray-500 mt-1">Jumlah tagihan tertunda</p>
                </div>
            </div>
        </div>

        <!-- Total Karyawan -->
        <div class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-yellow-500 text-white rounded-full shadow-md">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Total Karyawan</h2>
                    <p class="text-4xl font-bold text-yellow-500">{{ $totalEmployees }}</p>
                    <p class="text-sm text-gray-500 mt-1">Jumlah karyawan terdaftar</p>
                </div>
            </div>
        </div>

        <!-- Pelanggan Walk-in -->
        <div class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-green-600 text-white rounded-full shadow-md">
                    <i data-lucide="user" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Pelanggan Walk-in</h2>
                    <p class="text-4xl font-bold text-green-600">{{ $totalWalkinCustomers }}</p>
                    <p class="text-sm text-gray-500 mt-1">Jumlah pelanggan walk-in</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
