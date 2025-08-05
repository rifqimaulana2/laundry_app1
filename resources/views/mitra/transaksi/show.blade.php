<!-- resources/views/transaksi/show.blade.php -->
@extends('layouts.mitra')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Detail Transaksi #{{ $transaksi->id }}</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p><span class="font-semibold text-gray-700">Pesanan:</span> #{{ $transaksi->pesanan->id }}</p>
                <p><span class="font-semibold text-gray-700">Pelanggan:</span> {{ $transaksi->pesanan->user ? $transaksi->pesanan->user->name : $transaksi->pesanan->walkinCustomer?->nama ?? '-' }}</p>
                <p><span class="font-semibold text-gray-700">Nominal:</span> Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</p>
            </div>
            <div>
                <p><span class="font-semibold text-gray-700">Jenis Transaksi:</span> {{ $transaksi->jenis_transaksi }}</p>
                <p><span class="font-semibold text-gray-700">Metode Pembayaran:</span> {{ $transaksi->metode_bayar }}</p>
                <p><span class="font-semibold text-gray-700">Waktu:</span> {{ \Carbon\Carbon::parse($transaksi->waktu)->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <h3 class="text-lg font-bold text-gray-700 mb-2">Detail Pesanan</h3>
        @if ($transaksi->pesanan->pesananDetailKiloan->isNotEmpty())
            <h4 class="font-medium text-gray-600 mb-2">Kiloan</h4>
            <div class="overflow-x-auto mb-6">
                <table class="w-full text-left rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-sm font-semibold text-gray-700">Nama Paket</th>
                            <th class="p-3 text-sm font-semibold text-gray-700">Berat (kg)</th>
                            <th class="p-3 text-sm font-semibold text-gray-700">Harga per Kg</th>
                            <th class="p-3 text-sm font-semibold text-gray-700">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi->pesanan->pesananDetailKiloan as $detail)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-800">{{ $detail->layananMitraKiloan->layananKiloan->nama_paket }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $detail->berat_final ?? $detail->berat_sementara }} {{ $detail->berat_final ? '' : '(Sementara)' }}</td>
                                <td class="p-3 text-sm text-gray-800">Rp {{ number_format($detail->harga_per_kg, 0, ',', '.') }}</td>
                                <td class="p-3 text-sm text-gray-800">Rp {{ number_format($detail->subtotal ?? ($detail->berat_sementara * $detail->harga_per_kg), 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 mb-6">Tidak ada detail kiloan.</p>
        @endif
        @if ($transaksi->pesanan->pesananDetailSatuan->isNotEmpty())
            <h4 class="font-medium text-gray-600 mb-2">Satuan</h4>
            <div class="overflow-x-auto mb-6">
                <table class="w-full text-left rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-sm font-semibold text-gray-700">Nama Layanan</th>
                            <th class="p-3 text-sm font-semibold text-gray-700">Jumlah Item</th>
                            <th class="p-3 text-sm font-semibold text-gray-700">Harga per Item</th>
                            <th class="p-3 text-sm font-semibold text-gray-700">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi->pesanan->pesananDetailSatuan as $detail)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-800">{{ $detail->layananMitraSatuan->layananSatuan->nama_layanan }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $detail->jumlah_item }}</td>
                                <td class="p-3 text-sm text-gray-800">Rp {{ number_format($detail->harga_per_item, 0, ',', '.') }}</td>
                                <td class="p-3 text-sm text-gray-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 mb-6">Tidak ada detail satuan.</p>
        @endif
        <h3 class="text-lg font-bold text-gray-700 mb-2">Informasi Tagihan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p><span class="font-semibold text-gray-700">Total Tagihan:</span> Rp {{ number_format($transaksi->pesanan->tagihan->total_tagihan ?? 0, 0, ',', '.') }}</p>
                <p><span class="font-semibold text-gray-700">DP Dibayar:</span> Rp {{ number_format($transaksi->pesanan->tagihan->dp_dibayar, 0, ',', '.') }}</p>
                <p><span class="font-semibold text-gray-700">Sisa Tagihan:</span> Rp {{ number_format($transaksi->pesanan->tagihan->sisa_tagihan ?? 0, 0, ',', '.') }}</p>
            </div>
            <div>
                <p><span class="font-semibold text-gray-700">Metode Pembayaran:</span> {{ $transaksi->pesanan->tagihan->metode_bayar }}</p>
                <p><span class="font-semibold text-gray-700">Status Pembayaran:</span> {{ $transaksi->pesanan->tagihan->status_pembayaran }}</p>
                <p><span class="font-semibold text-gray-700">Jatuh Tempo Pelunasan:</span> {{ $transaksi->pesanan->tagihan->jatuh_tempo_pelunasan ? \Carbon\Carbon::parse($transaksi->pesanan->tagihan->jatuh_tempo_pelunasan)->format('d/m/Y') : '-' }}</p>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('mitra.transaksi.index') }}" class="inline-block bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Kembali ke Daftar Transaksi</a>
        </div>
    </div>
</div>
@endsection