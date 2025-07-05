@extends('layouts.mitra')

@section('title', 'Layanan Saya')

@section('content')
<h1 class="text-xl font-semibold mb-4">Layanan Kiloan</h1>

<table class="table-auto w-full mb-6 bg-white shadow rounded">
    <thead>
        <tr class="bg-blue-100 text-left">
            <th class="p-2">Nama Paket</th>
            <th class="p-2">Durasi</th>
            <th class="p-2">Harga/kg</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($layananKiloan as $layanan)
        <tr class="border-t">
            <td class="p-2">{{ $layanan->layanan->nama_paket ?? '-' }}</td>
            <td class="p-2">{{ $layanan->layanan->durasi_hari ?? '-' }} hari</td>
            <td class="p-2">Rp{{ number_format($layanan->harga_per_kg, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h1 class="text-xl font-semibold mb-4">Layanan Satuan</h1>

<table class="table-auto w-full bg-white shadow rounded">
    <thead>
        <tr class="bg-blue-100 text-left">
            <th class="p-2">Nama Layanan</th>
            <th class="p-2">Harga/item</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($layananSatuan as $layanan)
        <tr class="border-t">
            <td class="p-2">{{ $layanan->layanan->nama_layanan ?? '-' }}</td>
            <td class="p-2">Rp{{ number_format($layanan->harga_per_item, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
