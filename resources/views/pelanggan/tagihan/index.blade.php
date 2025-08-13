@extends('layouts.pelanggan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Daftar Tagihan</h1>

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <table class="w-full table-auto text-sm">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Pesanan ID</th>
                <th class="px-4 py-2">Mitra</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Sisa</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tagihans as $tagihan)
                <tr>
                    <td class="border px-4 py-2">{{ $tagihan->id }}</td>
                    <td class="border px-4 py-2">{{ $tagihan->pesanan_id }}</td>
                    <td class="border px-4 py-2">{{ $tagihan->pesanan->mitra->nama_toko ?? '-' }}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($tagihan->sisa_tagihan ?? 0, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($tagihan->status_pembayaran) }}</td>
                    <td class="border px-4 py-2 flex gap-2">
                        <a href="{{ route('pelanggan.tagihan.show', $tagihan->id) }}" class="text-blue-600 hover:underline">Detail</a>
                        @if($tagihan->status_pembayaran !== 'lunas')
                            <a href="{{ route('pelanggan.tagihan.bayar', $tagihan->id) }}" class="text-green-600 hover:underline">Bayar</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada tagihan ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
