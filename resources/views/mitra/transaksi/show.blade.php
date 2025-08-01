@extends('layouts.mitra')

@section('content')
    <div class="max-w-3xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Transaksi #{{ $transaksi->id }}</h1>
            <div class="space-y-4 mb-8">
                <div class="flex justify-between">
                    <span class="text-gray-600">Pesanan:</span>
                    <span class="font-semibold text-gray-900">#{{ $transaksi->pesanan->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Pelanggan:</span>
                    <span class="font-semibold text-gray-900">{{ $transaksi->pesanan->user ? $transaksi->pesanan->user->name : $transaksi->pesanan->walkinCustomer->nama }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Metode Pembayaran:</span>
                    <span class="font-semibold text-gray-900">{{ $transaksi->metode_bayar }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-semibold text-gray-900">{{ $transaksi->status_pembayaran }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Jatuh Tempo:</span>
                    <span class="font-semibold text-gray-900">{{ $transaksi->jatuh_tempo_pelunasan }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tanggal Pelunasan:</span>
                    <span class="font-semibold text-gray-900">{{ $transaksi->tanggal_pelunasan }}</span>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Detail Pesanan</h3>
            <h4 class="font-medium text-gray-600 mb-2">Kiloan</h4>
            @if ($transaksi->pesanan->pesananDetailKiloan->isNotEmpty())
                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-left rounded-xl overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-sm font-semibold text-gray-700">Nama Paket</th>
                                <th class="p-3 text-sm font-semibold text-gray-700">Berat (kg)</th>
                                <th class="p-3 text-sm font-semibold text-gray-700">Harga per Kg</th>
                                <th class="p-3 text-sm font-semibold text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi->pesanan->pesananDetailKiloan as $detail)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="p-3 text-sm text-gray-800">{{ $detail->layananMitraKiloan->layananKiloan->nama_paket }}</td>
                                    <td class="p-3 text-sm text-gray-800">{{ $detail->berat_sementara }}</td>
                                    <td class="p-3 text-sm text-gray-800">Rp {{ number_format($detail->harga_per_kg, 0, ',', '.') }}</td>
                                    <td class="p-3 text-sm text-gray-800">Rp {{ number_format($detail->berat_sementara * $detail->harga_per_kg, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 mb-6">Tidak ada detail kiloan.</p>
            @endif
            <h4 class="font-medium text-gray-600 mb-2">Satuan</h4>
            @if ($transaksi->pesanan->pesananDetailSatuan->isNotEmpty())
                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-left rounded-xl overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-sm font-semibold text-gray-700">Nama Layanan</th>
                                <th class="p-3 text-sm font-semibold text-gray-700">Jumlah Item</th>
                                <th class="p-3 text-sm font-semibold text-gray-700">Harga per Item</th>
                                <th class="p-3 text-sm font-semibold text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi->pesanan->pesananDetailSatuan as $detail)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="p-3 text-sm text-gray-800">{{ $detail->layananMitraSatuan->layananSatuan->nama_layanan }}</td>
                                    <td class="p-3 text-sm text-gray-800">{{ $detail->jumlah_item }}</td>
                                    <td class="p-3 text-sm text-gray-800">Rp {{ number_format($detail->harga_per_item, 0, ',', '.') }}</td>
                                    <td class="p-3 text-sm text-gray-800">Rp {{ number_format($detail->jumlah_item * $detail->harga_per_item, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 mb-6">Tidak ada detail satuan.</p>
            @endif
            <div class="mt-8 flex justify-end">
                <a href="{{ route('mitra.transaksi.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Kembali</a>
            </div>
        </div>
    </div>
@endsection