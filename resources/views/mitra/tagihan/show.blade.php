@extends('layouts.mitra')

@section('title', 'Detail Tagihan')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Detail Tagihan #{{ $tagihan->id }}</h2>

    <p><strong>Pesanan:</strong> #{{ $tagihan->pesanan->id }}</p>
    <p><strong>Pelanggan:</strong>
        @if($tagihan->pesanan->user)
            {{ $tagihan->pesanan->user->name }}
        @elseif($tagihan->pesanan->walkinCustomer)
            {{ $tagihan->pesanan->walkinCustomer->nama }}
        @else
            —
        @endif
    </p>
    <p><strong>Total Tagihan:</strong> {{ number_format($tagihan->total_tagihan) }}</p>
    <p><strong>DP Dibayar:</strong> {{ number_format($tagihan->dp_dibayar) }}</p>
    <p><strong>Sisa Tagihan:</strong> {{ number_format($tagihan->sisa_tagihan) }}</p>
    <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $tagihan->status_pembayaran)) }}</p>

    <h3 class="mt-6 font-semibold">Detail Layanan</h3>
    @if($tagihan->pesanan->kiloanDetails->count())
        <h4 class="mt-2 font-medium">Kiloan</h4>
        <table class="w-full text-sm border border-gray-200 mb-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1">Layanan</th>
                    <th class="px-2 py-1">Berat Final</th>
                    <th class="px-2 py-1">Harga/Kg</th>
                    <th class="px-2 py-1">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tagihan->pesanan->kiloanDetails as $detail)
                    <tr>
                        <td class="px-2 py-1">{{ $detail->layananMitraKiloan->layananKiloan->nama_layanan }}</td>
                        <td class="px-2 py-1">{{ $detail->berat_final }}</td>
                        <td class="px-2 py-1">{{ number_format($detail->harga_per_kg) }}</td>
                        <td class="px-2 py-1">{{ number_format($detail->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($tagihan->pesanan->satuanDetails->count())
        <h4 class="mt-2 font-medium">Satuan</h4>
        <table class="w-full text-sm border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1">Layanan</th>
                    <th class="px-2 py-1">Jumlah</th>
                    <th class="px-2 py-1">Harga/Item</th>
                    <th class="px-2 py-1">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tagihan->pesanan->satuanDetails as $detail)
                    <tr>
                        <td class="px-2 py-1">{{ $detail->layananMitraSatuan->layananSatuan->nama_layanan }}</td>
                        <td class="px-2 py-1">{{ $detail->jumlah_item }}</td>
                        <td class="px-2 py-1">{{ number_format($detail->harga_per_item) }}</td>
                        <td class="px-2 py-1">{{ number_format($detail->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
