@extends('layouts.mitra')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="p-4 max-w-6xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Daftar Transaksi</h2>

    <div class="bg-white shadow rounded p-4">
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">Pelanggan</th>
                    <th class="p-2 border">Total Tagihan</th>
                    <th class="p-2 border">Sisa Tagihan</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihans as $tagihan)
                    <tr>
                        <td class="p-2 border">{{ $tagihan->id }}</td>
                        <td class="p-2 border">
                            {{ $tagihan->pesanan->pelangganProfile->nama_lengkap
                                ?? $tagihan->pesanan->walkinCustomer->nama
                                ?? '-' }}
                        </td>
                        <td class="p-2 border">Rp{{ number_format($tagihan->total_tagihan,0,',','.') }}</td>
                        <td class="p-2 border">Rp{{ number_format($tagihan->sisa_tagihan,0,',','.') }}</td>
                        <td class="p-2 border">
                            {{ ucfirst(str_replace('_',' ', $tagihan->status_pembayaran)) }}
                        </td>
                        <td class="p-2 border text-center">
                            <a href="{{ route('mitra.transaksi.show', $tagihan->id) }}" 
                               class="bg-blue-600 text-white px-3 py-1 rounded text-xs">Detail</a>
                            @if($tagihan->sisa_tagihan > 0)
                                <a href="{{ route('mitra.transaksi.pelunasan', $tagihan->id) }}" 
                                   class="bg-green-600 text-white px-3 py-1 rounded text-xs">Pelunasan</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-2 text-center text-gray-500">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
