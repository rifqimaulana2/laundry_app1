@extends('layouts.mitra')

@section('title', 'Dashboard Mitra')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Total Pesanan</h2>
        <p class="text-2xl">{{ $totalPesanan }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Pesanan Baru</h2>
        <p class="text-2xl">{{ $pesananBaru }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Total Pendapatan</h2>
        <p class="text-2xl">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
</div>
@endsection
