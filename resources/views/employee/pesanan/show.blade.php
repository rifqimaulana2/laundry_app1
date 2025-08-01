@extends('layouts.employee')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">🧾 Detail Pesanan #{{ $pesanan->id }}</h1>
    
    <p><strong>Pelanggan:</strong> {{ $pesanan->user->name ?? $pesanan->walkinCustomer->nama }}</p>
    <p><strong>Jenis Pesanan:</strong> {{ $pesanan->jenis_pesanan }}</p>
    <p><strong>Tanggal Pesan:</strong> {{ $pesanan->tanggal_pesan }}</p>
    <p><strong>Catatan:</strong> {{ $pesanan->catatan_pesanan ?? '-' }}</p>

    @if ($pesanan->detailsKiloan->count())
        <h2 class="text-xl font-semibold mt-6">🧺 Detail Kiloan</h2>
        <table class="w-full table-auto border mt-2">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">Paket</th>
                    <th class="px-4 py-2">Berat Final</th>
                    <th class="px-4 py-2">Harga/Kg</th>
                    <th class="px-4 py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->detailsKiloan as $detail)
                    <tr>
                        <td class="border px-4 py-2">{{ $detail->layananMitraKiloan->layananKiloan->nama_paket }}</td>
                        <td class="border px-4 py-2">{{ $detail->berat_final ?? '-' }} Kg</td>
                        <td class="border px-4 py-2">Rp{{ number_format($detail->harga_per_kg) }}</td>
                        <td class="border px-4 py-2">Rp{{ number_format($detail->subtotal ?? 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($pesanan->detailsSatuan->count())
        <h2 class="text-xl font-semibold mt-6">👕 Detail Satuan</h2>
        <table class="w-full table-auto border mt-2">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">Layanan</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Harga/Item</th>
                    <th class="px-4 py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->detailsSatuan as $detail)
                    <tr>
                        <td class="border px-4 py-2">{{ $detail->layananMitraSatuan->layananSatuan->nama_layanan }}</td>
                        <td class="border px-4 py-2">{{ $detail->jumlah_item }}</td>
                        <td class="border px-4 py-2">Rp{{ number_format($detail->harga_per_item) }}</td>
                        <td class="border px-4 py-2">Rp{{ number_format($detail->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p class="mt-4">
        <strong>Total Tagihan:</strong> 
        Rp{{ number_format($pesanan->tagihan->total_tagihan ?? 0) }}
    </p>
    <p>
        <strong>Status Pembayaran:</strong> 
        {{ $pesanan->tagihan->status_pembayaran ?? '-' }}
    </p>
</div>
@endsection
