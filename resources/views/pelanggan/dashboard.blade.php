@extends('layouts.pelanggan')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-12 px-6">
    <div class="max-w-7xl mx-auto space-y-10">

        {{-- Greeting Section --}}
        <div class="bg-white rounded-3xl p-8 shadow-lg text-center border border-gray-100">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">👋 Hai, {{ Auth::user()->name }}</h1>
            <p class="mt-2 text-gray-600">Senang bertemu kembali! Yuk, mulai laundry dengan layanan terbaik hari ini.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-4">
                <a href="{{ route('pelanggan.mitra.index') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl text-sm font-semibold shadow transition">
                    🔍 Cari Mitra
                </a>
                <a href="{{ route('pelanggan.pesanan.index') }}"
                   class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-3 rounded-xl text-sm font-semibold shadow transition">
                    🧾 Pesanan Saya
                </a>
                <a href="{{ route('pelanggan.tagihan.index') }}"
                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-5 py-3 rounded-xl text-sm font-semibold shadow transition">
                    💳 Tagihan
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $stats = [
                    ['title' => 'Total Pesanan', 'value' => $totalPesanan ?? 0, 'color' => 'indigo'],
                    ['title' => 'Pesanan Aktif', 'value' => $pesananAktif ?? 0, 'color' => 'emerald'],
                    ['title' => 'Tagihan Belum Lunas', 'value' => 'Rp '.number_format($tagihanBelumLunas ?? 0,0,',','.'), 'color' => 'yellow'],
                    ['title' => 'Mitra Favorit', 'value' => $mitraFavorit->count() ?? 0, 'color' => 'pink'],
                ];
            @endphp

            @foreach($stats as $stat)
                <div class="bg-white p-6 rounded-2xl shadow-md border-t-4 border-{{ $stat['color'] }}-500">
                    <h2 class="text-sm text-gray-500 mb-1">{{ $stat['title'] }}</h2>
                    <p class="text-3xl font-bold text-{{ $stat['color'] }}-600">{{ $stat['value'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Mitra Favorit --}}
        @if (!empty($mitraFavorit) && count($mitraFavorit))
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                💙 Mitra Favorit Kamu
            </h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($mitraFavorit as $mitra)
                    <div class="bg-gray-50 border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
                        @if($mitra->foto_toko)
                            <img src="{{ asset('images/' . $mitra->foto_toko) }}" alt="{{ $mitra->nama_toko }}"
                                 class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">Belum ada foto</span>
                            </div>
                        @endif
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $mitra->nama_toko }}</h3>
                            <p class="text-sm text-gray-600 mt-1">📍 {{ $mitra->kecamatan }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $mitra->alamat_lengkap }}</p>
                            <a href="{{ route('pelanggan.mitra.show', $mitra->id) }}"
                               class="mt-auto inline-block bg-indigo-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-600 transition">
                                Detail Mitra
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
