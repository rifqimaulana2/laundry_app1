@extends('layouts.mitra')

@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi</h1>
            <p class="text-sm text-gray-500">ID: {{ $transaksi->id }}</p>
        </div>
        <a href="{{ route('mitra.riwayat.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-800 text-white text-sm">
            Kembali
        </a>
    </div>

    {{-- Card Utama --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 p-6 space-y-6">
        @php
            $isDp = strtolower($transaksi->jenis_transaksi) === 'dp';
            $badgeClass = $isDp
                ? 'bg-amber-100 text-amber-800 border-amber-200'
                : 'bg-emerald-100 text-emerald-800 border-emerald-200';

            $pelangganNama = $transaksi->pesanan?->user?->name
                ?? $transaksi->pesanan?->walkinCustomer?->name
                ?? '—';
        @endphp

        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center gap-2 text-xs font-medium px-2.5 py-1 rounded-full border {{ $badgeClass }}">
                {{ strtoupper($transaksi->jenis_transaksi) }}
            </span>
            <span class="text-sm text-gray-500">Dicatat: {{ \Carbon\Carbon::parse($transaksi->waktu)->format('d M Y H:i') }}</span>
            <span class="text-xs text-gray-400">({{ \Carbon\Carbon::parse($transaksi->waktu)->diffForHumans() }})</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <div>
                    <div class="text-xs text-gray-500">Nominal</div>
                    <div class="text-2xl font-semibold">Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Metode Pembayaran</div>
                    <div class="text-gray-800">{{ ucfirst($transaksi->metode_bayar ?? '-') }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Dicatat oleh</div>
                    <div class="text-gray-800">{{ $transaksi->user?->name ?? '—' }}</div>
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <div class="text-xs text-gray-500">Pesanan</div>
                    <div class="text-gray-800 font-semibold">#{{ $transaksi->pesanan?->id ?? '—' }}</div>
                    <div class="text-xs text-gray-500">{{ $transaksi->pesanan?->jenis_pesanan ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Pelanggan</div>
                    <div class="text-gray-800">{{ $pelangganNama }}</div>
                </div>
                @if($transaksi->pesanan?->tagihan)
                    <div class="rounded-lg bg-gray-50 p-3 border border-gray-100">
                        <div class="text-xs text-gray-500">Ringkasan Tagihan Saat Ini</div>
                        <div class="mt-1 text-sm text-gray-700">
                            Total: <span class="font-semibold">Rp {{ number_format($transaksi->pesanan->tagihan->total_tagihan, 0, ',', '.') }}</span><br>
                            DP: <span class="font-semibold">Rp {{ number_format($transaksi->pesanan->tagihan->dp_dibayar, 0, ',', '.') }}</span><br>
                            Sisa: <span class="font-semibold">Rp {{ number_format($transaksi->pesanan->tagihan->sisa_tagihan, 0, ',', '.') }}</span><br>
                            Status:
                            @if ($transaksi->pesanan->tagihan->status_pembayaran === 'lunas')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">Lunas</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">Belum Lunas</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Aksi cepat --}}
    <div class="flex flex-wrap gap-3">
        @if($transaksi->pesanan)
            <a href="{{ route('mitra.pesanan.show', $transaksi->pesanan->id) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm">
                Lihat Pesanan
            </a>
        @endif
        <a href="{{ route('mitra.riwayat.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-800 text-white text-sm">
            Kembali ke Riwayat
        </a>
    </div>
</div>
@endsection
