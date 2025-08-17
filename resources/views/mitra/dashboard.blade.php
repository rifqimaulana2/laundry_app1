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


    <!-- Menu Cepat -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('mitra.employee.index') }}" 
           class="bg-white p-6 rounded-3xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-yellow-500 text-white rounded-full">
                    <i data-lucide="user-plus" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Kelola Karyawan</h3>
                    <p class="text-gray-500 text-sm">Tambah & kelola employee laundry</p>
                </div>
            </div>
        </a>

        <a href="{{ route('mitra.pesanan.index') }}" 
           class="bg-white p-6 rounded-3xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-cyan-600 text-white rounded-full">
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Kelola Pesanan</h3>
                    <p class="text-gray-500 text-sm">Lihat & atur pesanan pelanggan</p>
                </div>
            </div>
        </a>

        <a href="{{ route('mitra.walkin_customer.index') }}" 
           class="bg-white p-6 rounded-3xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-green-600 text-white rounded-full">
                    <i data-lucide="user" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Walk-in Customer</h3>
                    <p class="text-gray-500 text-sm">Input pelanggan langsung</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
