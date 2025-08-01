@extends('layouts.app')
@section('title', 'Daftar Layanan - LaundryKuy')
@section('content')
<section class="bg-gradient-to-br from-teal-50 via-blue-50 to-white py-12">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl font-extrabold text-center text-gradient bg-gradient-to-r from-teal-500 via-blue-500 to-indigo-600 bg-clip-text text-transparent mb-6">Daftar Layanan LaundryKuy</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-blue-700 mb-2">Laundry Kiloan</h2>
                <ul class="list-disc list-inside text-gray-700 space-y-1">
                    <li>Cuci Reguler</li>
                    <li>Cuci Express</li>
                </ul>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-blue-700 mb-2">Laundry Satuan</h2>
                <ul class="list-disc list-inside text-gray-700 space-y-1">
                    <li>Jaket</li>
                    <li>Boneka</li>
                    <li>Tas Sekolah</li>
                    <li>Sepatu</li>
                </ul>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-blue-700 mb-2">Antar-Jemput</h2>
                <ul class="list-disc list-inside text-gray-700 space-y-1">
                    <li>Gratis untuk semua pesanan</li>
                </ul>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-blue-700 mb-2">Cuci Express</h2>
                <ul class="list-disc list-inside text-gray-700 space-y-1">
                    <li>6 Jam selesai (khusus area Indramayu)</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
