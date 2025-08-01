@extends('layouts.employee')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">🧾 Detail Tagihan #{{ $tagihan->id }}</h1>

    <div class="space-y-2">
        <p><strong>ID Pesanan:</strong> {{ $tagihan->pesanan_id }}</p>
        <p><strong>Pelanggan:</strong> 
            {{ $tagihan->pesanan->user->name ?? $tagihan->pesanan->walkinCustomer->nama ?? '-' }}
        </p>
        <p><strong>Total Tagihan:</strong> Rp{{ number_format($tagihan->total_tagihan ?? 0) }}</p>
        <p><strong>DP Dibayar:</strong> Rp{{ number_format($tagihan->dp_dibayar ?? 0) }}</p>
        <p><strong>Sisa Tagihan:</strong> Rp{{ number_format($tagihan->sisa_tagihan ?? 0) }}</p>
        <p><strong>Metode Bayar:</strong> {{ $tagihan->metode_bayar ?? '-' }}</p>
        <p><strong>Status Pembayaran:</strong> {{ $tagihan->status_pembayaran ?? '-' }}</p>
        <p><strong>Jatuh Tempo:</strong> {{ $tagihan->jatuh_tempo_pelunasan ?? '-' }}</p>
    </div>
</div>
@endsection
