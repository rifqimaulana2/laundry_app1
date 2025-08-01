@extends('layouts.pelanggan')

@section('content')
<div class="bg-[#f7f9fc] min-h-screen py-14 px-6">
    <div class="max-w-6xl mx-auto space-y-12">

        {{-- Hero Greeting --}}
        <div class="bg-white rounded-3xl p-10 shadow-md text-center">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">👋 Hai, {{ Auth::user()->name }}</h1>
            <p class="text-base text-gray-600">Senang bisa melihatmu kembali! Yuk, mulai laundry dengan layanan terbaik hari ini.</p>
            <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('pelanggan.mitra.index') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg text-sm font-semibold shadow transition">
                    🔍 Cari Mitra
                </a>
                <a href="{{ route('pelanggan.pesanan.index') }}"
                   class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-lg text-sm font-semibold shadow transition">
                    🧾 Pesanan Saya
                </a>
                <a href="{{ route('pelanggan.tagihan.index') }}"
                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-3 rounded-lg text-sm font-semibold shadow transition">
                    💳 Tagihan
                </a>
            </div>
        </div>

        {{-- Stats Card --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-md text-center border-t-4 border-indigo-600">
                <h2 class="text-sm text-gray-500 mb-1">Total Pesanan</h2>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalPesanan ?? 0 }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-md text-center border-t-4 border-emerald-500">
                <h2 class="text-sm text-gray-500 mb-1">Pesanan Aktif</h2>
                <p class="text-3xl font-bold text-emerald-500">{{ $pesananAktif ?? 0 }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-md text-center border-t-4 border-yellow-400">
                <h2 class="text-sm text-gray-500 mb-1">Tagihan Belum Lunas</h2>
                <p class="text-3xl font-bold text-yellow-500">Rp {{ number_format($tagihanBelumLunas ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-md text-center border-t-4 border-pink-400">
                <h2 class="text-sm text-gray-500 mb-1">Mitra Favorit</h2>
                <p class="text-3xl font-bold text-pink-400">{{ $mitraFavorit->count() ?? 0 }}</p>
            </div>
        </div>

        {{-- Mitra Favorit --}}
        @if (!empty($mitraFavorit) && count($mitraFavorit))
        <div class="bg-white rounded-2xl shadow-md p-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">💙 Mitra Favorit Kamu</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($mitraFavorit as $mitra)
                    <div class="bg-gray-50 p-5 rounded-xl shadow-sm hover:shadow-md transition flex flex-col items-start">
                        @if($mitra->foto_toko)
                            <img src="{{ asset('images/' . $mitra->foto_toko) }}" alt="{{ $mitra->nama_toko }}"
                                 class="w-full h-40 object-cover rounded mb-4">
                        @else
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center rounded mb-4">
                                <span class="text-gray-400 text-sm">Belum ada foto</span>
                            </div>
                        @endif
                        <h3 class="text-lg font-semibold text-gray-800">{{ $mitra->nama_toko }}</h3>
                        <p class="text-sm text-gray-600 mb-1">Kecamatan: {{ $mitra->kecamatan }}</p>
                        <p class="text-sm text-gray-600 mb-2">Alamat: {{ $mitra->alamat_lengkap }}</p>
                        <a href="{{ route('pelanggan.mitra.show', $mitra->id) }}"
                           class="inline-block mt-auto bg-indigo-500 text-white text-sm px-4 py-2 rounded hover:bg-indigo-600 transition">
                            Detail Mitra
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
