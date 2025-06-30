@extends('layouts.mitra')

@section('title', 'Detail Pesanan')

@section('content')
<h2 class="text-xl font-semibold mb-4">Detail Pesanan</h2>

<div class="bg-white p-4 rounded shadow mb-4">
    <p><strong>Kode:</strong> {{ $pesanan->kode }}</p>
    <p><strong>Pelanggan:</strong> {{ $pesanan->user->name }}</p>
    <p><strong>Alamat:</strong> {{ $pesanan->alamat }}</p>
    <p><strong>Status:</strong> {{ ucfirst($pesanan->status) }}</p>
</div>

@if ($pesanan->jenis_layanan === 'satuan')
    <h3 class="font-semibold mb-2">Layanan Satuan</h3>
    <ul class="list-disc pl-5 mb-4">
        @foreach ($pesanan->detailSatuan as $detail)
            <li>{{ $detail->nama_layanan }} - {{ $detail->jumlah }} pcs</li>
        @endforeach
    </ul>
@else
    <h3 class="font-semibold mb-2">Layanan Kiloan</h3>
    <ul class="list-disc pl-5 mb-4">
        @foreach ($pesanan->detailKiloan as $detail)
            <li>{{ $detail->jenis }} - {{ $detail->perkiraan_kg }} kg</li>
        @endforeach
    </ul>
@endif
@endsection
