@extends('layouts.mitra')

@section('title', 'Tagihan')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Daftar Tagihan</h2>

    <table class="w-full text-sm border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-2 py-1">ID Tagihan</th>
                <th class="px-2 py-1">Pesanan</th>
                <th class="px-2 py-1">Pelanggan</th>
                <th class="px-2 py-1">Total</th>
                <th class="px-2 py-1">DP Dibayar</th>
                <th class="px-2 py-1">Sisa Tagihan</th>
                <th class="px-2 py-1">Status</th>
                <th class="px-2 py-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tagihans as $tagihan)
                <tr>
                    <td class="px-2 py-1">{{ $tagihan->id }}</td>
                    <td class="px-2 py-1">#{{ $tagihan->pesanan->id }}</td>
                    <td class="px-2 py-1">
                        @if($tagihan->pesanan->user)
                            {{ $tagihan->pesanan->user->name }}
                        @elseif($tagihan->pesanan->walkinCustomer)
                            {{ $tagihan->pesanan->walkinCustomer->nama }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-2 py-1">{{ number_format($tagihan->total_tagihan) }}</td>
                    <td class="px-2 py-1">{{ number_format($tagihan->dp_dibayar) }}</td>
                    <td class="px-2 py-1">{{ number_format($tagihan->sisa_tagihan) }}</td>
                    <td class="px-2 py-1 capitalize">{{ str_replace('_', ' ', $tagihan->status_pembayaran) }}</td>
                    <td class="px-2 py-1 flex gap-2">
                        <a href="{{ route('mitra.tagihan.show', $tagihan->id) }}" class="text-blue-600 hover:underline">Detail</a>
                        @if($tagihan->status_pembayaran != 'lunas')
                            <form action="{{ route('mitra.tagihan.verifikasiLunas', $tagihan->id) }}" method="POST" onsubmit="return confirm('Tandai tagihan ini sebagai lunas?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-green-600 hover:underline">Tandai Lunas</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">Tidak ada tagihan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
