@extends('layouts.pelanggan')

@section('content')
@php
    $foto         = $mitra->foto_toko ? asset('images/'.$mitra->foto_toko) : asset('images/default-placeholder.jpg');
    $profileFoto  = $mitra->foto_profile ? asset('images/'.$mitra->foto_profile) : $foto;
    $rating       = isset($mitra->rating) ? (float)$mitra->rating : 4.6;
    $lat          = $mitra->latitude;
    $lng          = $mitra->longitude;
    $mapsQuery    = $mitra->formatted_address ? urlencode($mitra->formatted_address) : "{$lat},{$lng}";
@endphp

<div class="min-h-screen bg-slate-50 pb-12">

    {{-- HEADER --}}
    <header class="relative bg-gradient-to-r from-blue-700 to-indigo-700 text-white rounded-b-3xl shadow-xl overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ $foto }}'); filter: blur(6px);"></div>
        <div class="relative max-w-6xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center gap-6">
            <img src="{{ $profileFoto }}" alt="Foto Toko"
                class="w-28 h-28 md:w-36 md:h-36 rounded-full border-4 border-white object-cover shadow-lg">
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl font-extrabold">{{ $mitra->nama_toko }}</h1>
                <p class="mt-1 text-sm text-white/90">{{ $mitra->formatted_address ?? $mitra->alamat_lengkap }} • {{ $mitra->kecamatan }}</p>

                <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-3">
                    {{-- Rating --}}
                    <div class="flex items-center gap-1 bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm">
                        @for ($i=1; $i<=5; $i++)
                            @if($rating >= $i)
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.29 3.966a1 1 0 00.95.69h4.177c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.29 3.966c.3.922-.755 1.688-1.54 1.118L10 15.347l-3.446 2.648c-.784.57-1.839-.196-1.539-1.118l1.29-3.966a1 1 0 00-.364-1.118L2.506 9.393c-.783-.57-.38-1.81.588-1.81h4.177a1 1 0 00.95-.69l1.29-3.966z"/>
                                </svg>
                            @elseif($rating > $i-1)
                                <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 24 24">
                                    <defs>
                                        <linearGradient id="grad">
                                            <stop offset="50%" stop-color="currentColor"/>
                                            <stop offset="50%" stop-color="#e2e8f0"/>
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#grad)" d="M12 .587l3.668 7.431L24 9.748l-6 5.847 1.417 8.266L12 19.771 4.583 23.861 6 15.594 0 9.748l8.332-1.73z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.29 3.966a1 1 0 00.95.69h4.177c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.29 3.966c.3.922-.755 1.688-1.54 1.118L10 15.347l-3.446 2.648c-.784.57-1.839-.196-1.539-1.118l1.29-3.966a1 1 0 00-.364-1.118L2.506 9.393c-.783-.57-.38-1.81.588-1.81h4.177a1 1 0 00.95-.69l1.29-3.966z"/>
                                </svg>
                            @endif
                        @endfor
                        <span class="text-sm font-medium">{{ number_format($rating,1) }}</span>
                    </div>

                    {{-- Tombol Pesan --}}
                    <a href="{{ route('pelanggan.pesanan.create', ['mitra' => $mitra->id]) }}"
                        class="bg-white text-blue-700 hover:bg-slate-100 px-4 py-2 rounded-full font-semibold shadow-md transition">
                        Pesan Sekarang
                    </a>

                    {{-- Link Maps --}}
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $mapsQuery }}"
                        target="_blank" class="bg-white/20 px-4 py-2 rounded-full text-sm hover:bg-white/30 transition">
                        📍 Lihat di Maps
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="max-w-6xl mx-auto px-6 mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- INFO & JAM OPERASIONAL --}}
        <section class="lg:col-span-2 space-y-6">
            {{-- Info Mitra --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <h3 class="text-slate-500">📍 Alamat</h3>
                    <p class="font-medium">{{ $mitra->formatted_address ?? $mitra->alamat_lengkap }}</p>
                </div>
                <div>
                    <h3 class="text-slate-500">📞 Telepon</h3>
                    <p class="font-medium">{{ $mitra->no_telepon }}</p>
                </div>
                <div>
                    <h3 class="text-slate-500">🧭 Koordinat</h3>
                    <p class="font-medium">{{ $lat }}, {{ $lng }}</p>
                </div>
                <div>
                    <h3 class="text-slate-500">📌 Status</h3>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                        {{ $mitra->status_approve == 'disetujui' ? 'bg-emerald-100 text-emerald-700' :
                           ($mitra->status_approve == 'ditolak' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                        {{ ucfirst($mitra->status_approve) }}
                    </span>
                </div>
            </div>

            {{-- Jam Operasional --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">🕒 Jam Operasional</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($mitra->jamOperasionals as $jam)
                        <div class="bg-slate-50 p-3 rounded-lg border text-center">
                            <p class="font-semibold text-slate-700">{{ $jam->hari_buka }}</p>
                            <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($jam->jam_buka)->format('H:i') }} - {{ \Carbon\Carbon::parse($jam->jam_tutup)->format('H:i') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Layanan --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">🧺 Layanan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    {{-- Layanan Kiloan --}}
                    @foreach($mitra->layananMitraKiloan as $layanan)
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 hover:shadow-md transition">
                            <h4 class="font-semibold text-blue-800">{{ $layanan->layananKiloan->nama_paket ?? 'Kiloan' }}</h4>
                            <p class="text-sm text-blue-700">Durasi {{ $layanan->durasi_hari }} hari</p>
                            <p class="mt-2 font-bold text-blue-900">Rp{{ number_format($layanan->harga_per_kg,0,',','.') }}/Kg</p>
                        </div>
                    @endforeach

                    {{-- Layanan Satuan --}}
                    @foreach($mitra->layananMitraSatuan as $layanan)
                        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 hover:shadow-md transition">
                            <h4 class="font-semibold text-emerald-800">{{ $layanan->layananSatuan->nama_layanan ?? 'Satuan' }}</h4>
                            <p class="text-sm text-emerald-700">Durasi {{ $layanan->durasi_hari }} hari</p>
                            <p class="mt-2 font-bold text-emerald-900">Rp{{ number_format($layanan->harga_per_item,0,',','.') }}/item</p>
                        </div>
                    @endforeach

                    @if($mitra->layananMitraKiloan->isEmpty() && $mitra->layananMitraSatuan->isEmpty())
                        <div class="col-span-full text-center py-6 text-slate-500 italic">Belum ada layanan tersedia.</div>
                    @endif
                </div>
            </div>
        </section>

        {{-- SIDEBAR --}}
        <aside class="space-y-6">
            {{-- Kontak --}}
            <div class="bg-white p-4 rounded-2xl shadow-sm">
                <h4 class="text-sm text-slate-500 mb-3">Kontak Cepat</h4>
                <a href="tel:{{ $mitra->no_telepon }}" class="block w-full text-center bg-blue-50 text-blue-700 py-2 rounded-full font-medium">Telepon</a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$mitra->no_telepon) }}" target="_blank" class="mt-3 block w-full text-center bg-emerald-50 text-emerald-700 py-2 rounded-full font-medium">WhatsApp</a>
            </div>

            {{-- Map --}}
            <div class="bg-white p-4 rounded-2xl shadow-sm">
                <h4 class="text-sm text-slate-500 mb-3">Lokasi</h4>
                <div class="w-full h-36 rounded-lg overflow-hidden">
                    <iframe
                        class="w-full h-full"
                        src="https://maps.google.com/maps?q={{ $mapsQuery }}&z=15&output=embed"
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </aside>
    </main>
</div>
@endsection
