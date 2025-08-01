@extends('layouts.employee')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">👷 Dashboard Pegawai</h1>
        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
        <p class="mt-1 text-sm text-gray-500">
            Di sini kamu bisa melihat dan mengelola data pesanan laundry milik mitramu.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-100 p-5 rounded-xl shadow">
            <h2 class="text-lg font-semibold text-blue-800">Total Pesanan</h2>
            <p class="text-3xl font-bold text-blue-900 mt-2">{{ $pesananCount }}</p>
        </div>
        <div class="bg-yellow-100 p-5 rounded-xl shadow">
            <h2 class="text-lg font-semibold text-yellow-800">Tagihan Belum Lunas</h2>
            <p class="text-3xl font-bold text-yellow-900 mt-2">{{ $tagihanPending }}</p>
        </div>
        <div class="bg-green-100 p-5 rounded-xl shadow">
            <h2 class="text-lg font-semibold text-green-800">Pelanggan Walk-In</h2>
            <p class="text-3xl font-bold text-green-900 mt-2">{{ $walkinCount }}</p>
        </div>
    </div>
</div>
@endsection
