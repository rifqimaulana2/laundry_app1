@extends('layouts.superadmin')

@section('title', 'Dashboard Superadmin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-8 tracking-tight">Superadmin Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Pengguna -->
        <div class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-blue-600 text-white rounded-full shadow-md">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Total Pengguna</h2>
                    <p class="text-4xl font-bold text-blue-600">{{ $totalUsers }}</p>
                    <p class="text-sm text-gray-500 mt-1">Jumlah pengguna terdaftar</p>
                </div>
            </div>
        </div>

        <!-- Total Mitra -->
        <div class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-green-600 text-white rounded-full shadow-md">
                    <i data-lucide="handshake" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Total Mitra</h2>
                    <p class="text-4xl font-bold text-green-600">{{ $totalMitras }}</p>
                    <p class="text-sm text-gray-500 mt-1">Jumlah mitra aktif</p>
                </div>
            </div>
        </div>

        <!-- Total Karyawan -->
        <div class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-yellow-500 text-white rounded-full shadow-md">
                    <i data-lucide="briefcase" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Total Karyawan</h2>
                    <p class="text-4xl font-bold text-yellow-500">{{ $totalEmployees }}</p>
                    <p class="text-sm text-gray-500 mt-1">Jumlah karyawan terdaftar</p>
                </div>
            </div>
        </div>

        <!-- Total Pesanan -->
        <div class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-cyan-600 text-white rounded-full shadow-md">
                    <i data-lucide="shopping-cart" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Total Pesanan</h2>
                    <p class="text-4xl font-bold text-cyan-600">{{ $totalPesanans }}</p>
                    <p class="text-sm text-gray-500 mt-1">Jumlah pesanan selesai</p>
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
    </div>
</div>
@endsection