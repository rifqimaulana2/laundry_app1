@extends('layouts.mitra')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Transaksi</h1>
            <div class="overflow-x-auto">
                <table class="w-full text-left rounded-xl overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 text-sm font-semibold text-gray-700">ID Transaksi</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Pesanan</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Pelanggan</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Metode Pembayaran</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Tanggal Pelunasan</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $transaksi)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-4 text-sm text-gray-800">{{ $transaksi->id }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $transaksi->pesanan->id }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $transaksi->pesanan->user ? $transaksi->pesanan->user->name : $transaksi->pesanan->walkinCustomer->nama }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $transaksi->metode_bayar }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $transaksi->tanggal_pelunasan }}</td>
                                <td class="p-4">
                                    <a href="{{ route('mitra.transaksi.show', $transaksi) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-medium">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-sm text-gray-500">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection