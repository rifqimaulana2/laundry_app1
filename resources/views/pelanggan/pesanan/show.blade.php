@extends('layouts.pelanggan')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-2xl shadow-xl space-y-6">
        <h1 class="text-3xl font-bold text-gray-800">📦 Detail Pesanan #{{ $pesanan->id }}</h1>

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif
        @if (session('info'))
            <div class="mb-4 p-4 bg-blue-100 text-blue-700 rounded-md">
                {{ session('info') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div><span class="font-semibold">Mitra:</span> {{ $pesanan->mitra->nama_toko }}</div>
            <div><span class="font-semibold">Jenis Pesanan:</span> {{ $pesanan->jenis_pesanan }}</div>
            <div><span class="font-semibold">Tanggal Pesan:</span> {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}</div>
            <div><span class="font-semibold">Catatan:</span> {{ $pesanan->catatan_pesanan ?? '-' }}</div>
            <div><span class="font-semibold">Status Pembayaran:</span>
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                    {{ $pesanan->tagihan->status_pembayaran === 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($pesanan->tagihan->status_pembayaran) }}
                </span>
            </div>
            <div><span class="font-semibold">Total Tagihan:</span> Rp {{ number_format($pesanan->tagihan->total_tagihan ?? 0, 0, ',', '.') }}</div>
            <div><span class="font-semibold">DP Dibayar:</span> Rp {{ number_format($pesanan->tagihan->dp_dibayar ?? 0, 0, ',', '.') }}</div>
            <div><span class="font-semibold">Sisa Tagihan:</span> Rp {{ number_format($pesanan->tagihan->sisa_tagihan ?? 0, 0, ',', '.') }}</div>
            @if ($pesanan->tipe_dp_wajib === 'Ya' && $pesanan->tagihan->dp_dibayar == 0)
                <div><span class="font-semibold text-red-600">DP Harus Dibayar:</span> Rp {{ number_format($pesanan->tagihan->total_tagihan * 0.5, 0, ',', '.') }}</div>
            @endif
        </div>

        @if ($pesanan->kiloanDetails->count())
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2 mt-6">🧺 Detail Kiloan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-blue-50 text-gray-700 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-2 text-left">Paket</th>
                            <th class="px-4 py-2 text-left">Berat Final</th>
                            <th class="px-4 py-2 text-left">Harga/Kg</th>
                            <th class="px-4 py-2 text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($pesanan->kiloanDetails as $detail)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $detail->layananMitraKiloan->layananKiloan->nama_paket }}</td>
                            <td class="px-4 py-2">{{ $detail->berat_final ?? '-' }} kg</td>
                            <td class="px-4 py-2">Rp {{ number_format($detail->harga_per_kg, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                {{ $detail->subtotal ? 'Rp ' . number_format($detail->subtotal, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if ($pesanan->satuanDetails->count())
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
                            <td class="px-4 py-2">{{ $detail->layananMitraSatuan->layananSatuan->nama_layanan }}</td>
                            <td class="px-4 py-2">{{ $detail->jumlah_item }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($detail->harga_per_item, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="mt-6 flex gap-4">
            @if ($pesanan->tipe_dp_wajib === 'Ya' && $pesanan->tagihan->dp_dibayar == 0)
                <a href="{{ route('pelanggan.tagihan.bayar', $pesanan->tagihan) }}"
                   class="inline-block bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                    💳 Bayar DP
                </a>
            @elseif ($pesanan->tagihan && $pesanan->tagihan->sisa_tagihan > 0 && $pesanan->tagihan->dp_dibayar > 0)
                <a href="{{ route('pelanggan.pesanan.pelunasan', $pesanan) }}"
                   class="inline-block bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                    💳 Lunasi Tagihan
                </a>
            @endif
            <a href="{{ route('pelanggan.pesanan.index') }}"
               class="inline-block bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition">
                Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
</div>
@endsection