@extends('layouts.pelanggan')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    @if (isset($error))
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg text-center font-semibold shadow-sm">
            {{ $error }}
        </div>
    @else
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden transition duration-300">

            {{-- Profil Header --}}
            <div class="relative flex flex-col md:flex-row items-center md:items-start gap-8 p-10 bg-gradient-to-br from-blue-100 via-sky-100 to-indigo-100">
                <div class="absolute inset-0 bg-pattern-light opacity-10"></div>
                <img src="{{ asset('storage/' . $mitra->foto_profile) }}" alt="Foto Mitra"
                    class="w-40 h-40 rounded-full object-cover ring-4 ring-white shadow-md z-10 transition-transform duration-300 hover:scale-105">
                <div class="z-10 text-center md:text-left space-y-1 flex-grow">
                    <h1 class="text-4xl font-bold text-slate-800 leading-snug">{{ $mitra->nama_toko }}</h1>
                    <p class="text-gray-700"><strong class="text-blue-800">📍 Alamat:</strong> {{ $mitra->alamat_lengkap }}</p>
                    <p class="text-gray-700"><strong class="text-blue-800">📌 Kecamatan:</strong> {{ $mitra->kecamatan }}</p>
                    <p class="text-gray-700"><strong class="text-blue-800">📞 Telepon:</strong> {{ $mitra->no_telepon }}</p>
                    <p class="text-gray-700"><strong class="text-blue-800">🧭 Lokasi:</strong> {{ $mitra->latitude }}, {{ $mitra->longitude }}</p>
                </div>
            </div>

            {{-- Jam Operasional --}}
            <section class="px-10 py-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    🕒 Jam Operasional
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach ($mitra->jamOperasionals as $jam)
                        <div class="bg-white border border-blue-100 text-blue-800 rounded-xl shadow-sm px-4 py-3 text-center hover:shadow-md hover:scale-105 transition">
                            <div class="font-bold text-md">{{ $jam->hari_buka }}</div>
                            <div class="text-sm text-blue-700">{{ $jam->jam_buka }} - {{ $jam->jam_tutup }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Layanan Kiloan --}}
            <section class="px-10 py-8 bg-sky-50">
                <h2 class="text-2xl font-semibold text-sky-900 mb-6 flex items-center gap-2">
                    🧺 Layanan Kiloan
                </h2>
                <div class="space-y-5">
                    @forelse ($mitra->layananMitraKiloan as $layanan)
                        <div class="bg-white border-l-4 border-sky-400 rounded-lg shadow-md p-5 hover:shadow-lg transition hover:-translate-y-1">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
                                <div class="font-semibold text-lg text-sky-800">
                                    {{ $layanan->layananKiloan->nama_paket ?? 'Nama Paket Tidak Tersedia' }}
                                </div>
                                <div class="text-sm bg-sky-100 text-sky-800 px-3 py-1 rounded-full">
                                    Durasi {{ $layanan->durasi_hari }} hari
                                </div>
                            </div>
                            <p class="text-gray-700 mt-1">Harga: <strong>Rp{{ number_format($layanan->harga_per_kg, 0, ',', '.') }}</strong> / Kg</p>
                        </div>
                    @empty
                        <p class="text-gray-500 italic text-center py-4">Belum ada layanan kiloan tersedia.</p>
                    @endforelse
                </div>
            </section>

            {{-- Layanan Satuan --}}
            <section class="px-10 py-8 bg-emerald-50">
                <h2 class="text-2xl font-semibold text-emerald-900 mb-6 flex items-center gap-2">
                    🧦 Layanan Satuan
                </h2>
                <div class="space-y-5">
                    @forelse ($mitra->layananMitraSatuan as $layanan)
                        <div class="bg-white border-l-4 border-emerald-400 rounded-lg shadow-md p-5 hover:shadow-lg transition hover:-translate-y-1">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
                                <div class="font-semibold text-lg text-emerald-800">
                                    {{ $layanan->layananSatuan->nama_layanan ?? 'Nama Layanan Tidak Tersedia' }}
                                </div>
                                <div class="text-sm bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full">
                                    Durasi {{ $layanan->durasi_hari }} hari
                                </div>
                            </div>
                            <p class="text-gray-700 mt-1">Harga: <strong>Rp{{ number_format($layanan->harga_per_item, 0, ',', '.') }}</strong> / item</p>
                        </div>
                    @empty
                        <p class="text-gray-500 italic text-center py-4">Belum ada layanan satuan tersedia.</p>
                    @endforelse
                </div>
            </section>

            {{-- CTA Button --}}
            <div class="text-center py-14 bg-gradient-to-b from-white to-sky-50 rounded-b-3xl">
                @if ($mitra && $mitra->id)
                    <a href="{{ route('pelanggan.pesanan.create', ['mitra' => $mitra->id]) }}"
                        class="inline-block bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white text-lg font-semibold px-10 py-4 rounded-full shadow-lg hover:shadow-xl transition transform hover:scale-105 animate-bounce-subtle">
                        ✨ Buat Pesanan Sekarang
                    </a>
                @else
                    <p class="text-red-500 text-center mt-4">ID Mitra tidak ditemukan. Tidak dapat membuat pesanan.</p>
                @endif
            </div>

        </div>
    @endif
</div>

{{-- Tambahan CSS --}}
<style>
    .bg-pattern-light {
        background-image: url("data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%239C92AC' fill-opacity='0.1'%3E%3Cpath d='M0 0h6v6H0z'/%3E%3C/g%3E%3C/svg%3E");
        background-repeat: repeat;
    }

    @keyframes bounceSubtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .animate-bounce-subtle {
        animation: bounceSubtle 3s infinite ease-in-out;
    }
</style>
@endsection
