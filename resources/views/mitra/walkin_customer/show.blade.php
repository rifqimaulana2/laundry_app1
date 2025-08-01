@extends('layouts.mitra')

@section('content')
    <div class="max-w-xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Pelanggan Walk-in: {{ $walkinCustomer->nama }}</h1>
            <div class="space-y-4 mb-8">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nama:</span>
                    <span class="font-semibold text-gray-900">{{ $walkinCustomer->nama }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">No Telepon:</span>
                    <span class="font-semibold text-gray-900">{{ $walkinCustomer->no_tlp }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Alamat:</span>
                    <span class="font-semibold text-gray-900">{{ $walkinCustomer->alamat }}</span>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Pesanan</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left rounded-xl overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-sm font-semibold text-gray-700">ID Pesanan</th>
                            <th class="p-3 text-sm font-semibold text-gray-700">Jenis Pesanan</th>
                            <th class="p-3 text-sm font-semibold text-gray-700">Tanggal Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($walkinCustomer->pesanans as $pesanan)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-800">{{ $pesanan->id }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $pesanan->jenis_pesanan }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $pesanan->tanggal_pesan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3 text-center text-sm text-gray-500">Belum ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection