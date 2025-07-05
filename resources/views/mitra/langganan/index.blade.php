@extends('layouts.mitra')

@section('title', 'Langganan Mitra')

@section('content')
<h1 class="text-xl font-semibold mb-4">Status Langganan</h1>

<div class="bg-white p-4 shadow rounded">
    <p><strong>Status Langganan:</strong> {{ $mitra->langganan_aktif ? 'Aktif' : 'Tidak Aktif' }}</p>
    <p><strong>Tanggal Berakhir:</strong> {{ $mitra->tanggal_langganan_berakhir ?? '-' }}</p>
</div>
@endsection
