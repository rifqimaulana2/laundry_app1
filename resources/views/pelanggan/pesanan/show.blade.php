{{-- resources/views/pelanggan/pesanan/show.blade.php --}}
@extends('layouts.pelanggan')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-2xl shadow-xl space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">📦 Detail Pesanan #{{ $pesanan->id }}</h1>

        {{-- Flash messages --}}
        @foreach (['error' => 'red', 'success' => 'green', 'info' => 'blue'] as $msg => $color)
            @if (session($msg))
                <div class="p-4 bg-{{ $color }}-100 text-{{ $color }}-700 rounded-md">
                    {{ session($msg) }}
                </div>
            @endif
        @endforeach

        {{-- Ringkasan Tagihan --}}
        @if ($pesanan->tagihan)
            <div class="border rounded-lg p-4 bg-gray-50">
                <h2 class="text-lg font-semibold mb-3">💰 Ringkasan Tagihan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div><span class="font-semibold">No. Tagihan:</span> {{ $pesanan->tagihan->order_id }}</div>
                    <div><span class="font-semibold">Status:</span>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $pesanan->tagihan->status_pembayaran === 'lunas' 
                                ? 'bg-green-100 text-green-800' 
                                : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($pesanan->tagihan->status_pembayaran) }}
                        </span>
                    </div>
                    <div><span class="font-semibold">Total:</span> Rp {{ number_format($pesanan->tagihan->total_tagihan, 0, ',', '.') }}</div>
                    <div><span class="font-semibold">DP Dibayar:</span> Rp {{ number_format($pesanan->tagihan->dp_dibayar, 0, ',', '.') }}</div>
                    <div><span class="font-semibold">Sisa:</span> Rp {{ number_format($pesanan->tagihan->sisa_tagihan, 0, ',', '.') }}</div>
                    @if ($pesanan->tagihan->jatuh_tempo_pelunasan)
                        <div><span class="font-semibold">Jatuh Tempo:</span> 
                            {{ \Carbon\Carbon::parse($pesanan->tagihan->jatuh_tempo_pelunasan)->format('d M Y') }}
                        </div>
                    @endif
                </div>

                {{-- Tombol Bayar --}}
                <div class="mt-4 flex gap-3">
                    @if ($pesanan->tipe_dp_wajib === 'Ya' && $pesanan->tagihan->dp_dibayar == 0)
                        <a href="{{ route('pelanggan.tagihan.bayar', $pesanan->tagihan) }}"
                           class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                            💳 Bayar DP
                        </a>
                    @elseif ($pesanan->tagihan->sisa_tagihan > 0 && $pesanan->tagihan->dp_dibayar > 0)
                        <a href="{{ route('pelanggan.tagihan.bayar', $pesanan->tagihan->id) }}"
                           class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                            💳 Lunasi Tagihan
                        </a>
                    @endif
                </div>
            </div>
        @endif

        @php
            $hasKiloan = $pesanan->kiloanDetails && $pesanan->kiloanDetails->count() > 0;
            $hasSatuan = $pesanan->satuanDetails && $pesanan->satuanDetails->count() > 0;
        @endphp

        {{-- Pesan jika tidak ada detail --}}
        @if (! $hasKiloan && ! $hasSatuan)
            <div class="p-4 bg-yellow-50 text-yellow-800 rounded-md">
                Belum ada detail untuk pesanan ini.
            </div>
        @endif

        {{-- Detail Kiloan --}}
        @if ($hasKiloan)
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">🧺 Detail Kiloan</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-blue-50 text-gray-700 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-2 text-left">Paket</th>
                                <th class="px-4 py-2 text-left">Berat Sementara</th>
                                <th class="px-4 py-2 text-left">Berat Final</th>
                                <th class="px-4 py-2 text-left">Harga/Kg</th>
                                <th class="px-4 py-2 text-left">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($pesanan->kiloanDetails as $detail)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2">{{ optional(optional($detail->layananMitraKiloan)->layananKiloan)->nama_paket ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $detail->berat_sementara ?? '-' }} kg</td>
                                    <td class="px-4 py-2">{{ $detail->berat_final ?? '-' }} kg</td>
                                    <td class="px-4 py-2">Rp {{ number_format($detail->harga_per_kg ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Detail Satuan --}}
        @if ($hasSatuan)
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2 mt-6">🧦 Detail Satuan</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-blue-50 text-gray-700 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-2 text-left">Layanan</th>
                                <th class="px-4 py-2 text-left">Jumlah</th>
                                <th class="px-4 py-2 text-left">Harga/Item</th>
                                <th class="px-4 py-2 text-left">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($pesanan->satuanDetails as $detail)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2">{{ optional(optional($detail->layananMitraSatuan)->layananSatuan)->nama_layanan ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $detail->jumlah_item }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($detail->harga_per_item ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="pt-4">
            <a href="{{ route('pelanggan.pesanan.index') }}"
               class="inline-block bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition">
                ⬅ Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
</div>
@endsection
