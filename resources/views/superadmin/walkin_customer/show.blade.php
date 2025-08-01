<!-- resources/views/superadmin/walkin_customer/show.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-10 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">Detail Pelanggan Walk-in: {{ $walkinCustomer->nama }}</h1>
        <div class="bg-white rounded-3xl shadow-lg p-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="mb-2"><span class="font-semibold text-gray-700">Nama:</span> {{ $walkinCustomer->nama }}</p>
                    <p class="mb-2"><span class="font-semibold text-gray-700">No Telepon:</span> {{ $walkinCustomer->no_tlp }}</p>
                    <p class="mb-2"><span class="font-semibold text-gray-700">Alamat:</span> {{ $walkinCustomer->alamat }}</p>
                </div>
                <div>
                    <p class="mb-2"><span class="font-semibold text-gray-700">Mitra:</span> <span class="px-3 py-1 rounded-lg bg-green-100 text-green-800 text-xs font-semibold">{{ $walkinCustomer->mitra->nama_toko }}</span></p>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Pesanan</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 font-semibold text-gray-700">ID Pesanan</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Jenis Pesanan</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Tanggal Pesan</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($walkinCustomer->pesanans as $pesanan)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $pesanan->id }}</td>
                            <td class="py-3 px-4">{{ $pesanan->jenis_pesanan }}</td>
                            <td class="py-3 px-4">{{ $pesanan->tanggal_pesan }}</td>
                            <td class="py-3 px-4">
                                @if($pesanan->status_pesanan == 'Selesai')
                                    <span class="px-3 py-1 rounded-lg bg-green-100 text-green-800 text-xs font-semibold">{{ $pesanan->status_pesanan }}</span>
                                @elseif($pesanan->status_pesanan == 'Proses')
                                    <span class="px-3 py-1 rounded-lg bg-yellow-100 text-yellow-800 text-xs font-semibold">{{ $pesanan->status_pesanan }}</span>
                                @else
                                    <span class="px-3 py-1 rounded-lg bg-gray-200 text-gray-700 text-xs font-semibold">{{ $pesanan->status_pesanan ?? 'Menunggu' }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection