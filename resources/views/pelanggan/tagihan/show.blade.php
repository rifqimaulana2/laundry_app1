@extends('layouts.pelanggan')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg mt-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🧾 Detail Tagihan #{{ $tagihan->id }}</h1>

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-4 text-sm text-gray-700">
        <div class="flex justify-between">
            <span class="font-semibold">ID Pesanan:</span>
            <span>#{{ $tagihan->pesanan_id }}</span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Mitra:</span>
            <span>{{ $tagihan->pesanan->mitra->nama_toko ?? '-' }}</span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Total Tagihan:</span>
            <span>Rp {{ number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">DP Dibayar:</span>
            <span>Rp {{ number_format($tagihan->dp_dibayar ?? 0, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Sisa Tagihan:</span>
            <span>Rp {{ number_format($tagihan->sisa_tagihan ?? 0, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Metode Pembayaran:</span>
            <span>{{ $tagihan->metode_bayar ?? '-' }}</span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Status Pembayaran:</span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold
                @if ($tagihan->status_pembayaran === 'lunas')
                    bg-green-100 text-green-700
                @elseif ($tagihan->status_pembayaran === 'belum lunas')
                    bg-yellow-100 text-yellow-700
                @else
                    bg-gray-100 text-gray-700
                @endif
            ">
                {{ ucfirst($tagihan->status_pembayaran) }}
            </span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Jatuh Tempo:</span>
            <span>
                {{ $tagihan->jatuh_tempo_pelunasan 
                    ? \Carbon\Carbon::parse($tagihan->jatuh_tempo_pelunasan)->translatedFormat('d M Y') 
                    : '-' 
                }}
            </span>
        </div>
    </div>

    <div class="mt-6 flex gap-4">
        @if($tagihan->status_pembayaran !== 'lunas')
            <a href="{{ route('pelanggan.tagihan.bayar', ['tagihan' => $tagihan->id]) }}"
               class="inline-block bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                💳 Bayar Sekarang
            </a>
        @endif
        <a href="{{ route('pelanggan.tagihan.index') }}"
           class="inline-block bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition">
            Kembali
        </a>
    </div>
</div>
@endsection