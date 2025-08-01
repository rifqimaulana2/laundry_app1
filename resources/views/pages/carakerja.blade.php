@extends('layouts.app')
@section('title', 'Cara Kerja - LaundryKuy')
@section('content')
<section class="bg-gradient-to-br from-blue-50 via-teal-50 to-white py-12">
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-4xl font-extrabold text-center text-gradient bg-gradient-to-r from-blue-500 via-teal-500 to-indigo-600 bg-clip-text text-transparent mb-6">Cara Kerja LaundryKuy</h1>
        <ol class="list-decimal list-inside text-gray-700 space-y-4 bg-white rounded-xl shadow-lg p-8">
            <li><span class="font-bold text-teal-600">Daftar/Login:</span> Pelanggan dan mitra mendaftar di website LaundryKuy.</li>
            <li><span class="font-bold text-teal-600">Pilih Layanan:</span> Pelanggan memilih layanan laundry sesuai kebutuhan.</li>
            <li><span class="font-bold text-teal-600">Isi Detail Pesanan:</span> Masukkan detail pesanan dan alamat penjemputan.</li>
            <li><span class="font-bold text-teal-600">Antar-Jemput:</span> Kurir menjemput dan mengantar pakaian sesuai jadwal.</li>
            <li><span class="font-bold text-teal-600">Pelacakan & Pembayaran:</span> Pantau status pesanan dan lakukan pembayaran online.</li>
        </ol>
    </div>
</section>
@endsection
