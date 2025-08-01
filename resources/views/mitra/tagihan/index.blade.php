@extends('layouts.mitra')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Tagihan</h1>
            <div class="overflow-x-auto">
                <table class="w-full text-left rounded-xl overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 text-sm font-semibold text-gray-700">ID Tagihan</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Pesanan</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Pelanggan</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Metode Pembayaran</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Status</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Jatuh Tempo</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tagihans as $tagihan)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-4 text-sm text-gray-800">{{ $tagihan->id }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $tagihan->pesanan->id }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $tagihan->pesanan->user ? $tagihan->pesanan->user->name : $tagihan->pesanan->walkinCustomer->nama }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $tagihan->metode_bayar }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $tagihan->status_pembayaran }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $tagihan->jatuh_tempo_pelunasan }}</td>
                                <td class="p-4">
                                    <a href="{{ route('mitra.tagihan.show', $tagihan) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-medium">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-sm text-gray-500">Belum ada tagihan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection