@extends('layouts.mitra')

@section('content')
    <div class="max-w-3xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Pesanan #{{ $pesanan->id }}</h1>
            <div class="space-y-3 mb-6">
                <p><span class="font-semibold text-gray-700">Pelanggan:</span> {{ $pesanan->user ? $pesanan->user->name : $pesanan->walkinCustomer->nama }}</p>
                <p><span class="font-semibold text-gray-700">Jenis Pesanan:</span> {{ $pesanan->jenis_pesanan }}</p>
                <p><span class="font-semibold text-gray-700">Tanggal Pesan:</span> {{ $pesanan->tanggal_pesan }}</p>
                <p><span class="font-semibold text-gray-700">Status Pembayaran:</span> {{ $pesanan->tagihan->status_pembayaran ?? 'Menunggu' }}</p>
                <p><span class="font-semibold text-gray-700">Catatan Pesanan:</span> {{ $pesanan->catatan_pesanan ?? '-' }}</p>
                <p><span class="font-semibold text-gray-700">Opsi Jemput:</span> {{ $pesanan->opsi_jemput }}</p>
                <p><span class="font-semibold text-gray-700">Jadwal Jemput:</span> {{ $pesanan->jadwal_jemput ?? '-' }}</p>
                <p><span class="font-semibold text-gray-700">Opsi Antar:</span> {{ $pesanan->opsi_antar }}</p>
                <p><span class="font-semibold text-gray-700">Jadwal Antar:</span> {{ $pesanan->jadwal_antar ?? '-' }}</p>
                <p><span class="font-semibold text-gray-700">Catatan Pengiriman:</span> {{ $pesanan->catatan_pengiriman ?? '-' }}</p>
            </div>

            <h3 class="text-lg font-bold text-gray-700 mb-2">Detail Kiloan</h3>
            @if ($pesanan->pesananDetailKiloan->isNotEmpty())
                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-left rounded-xl overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-4 text-sm font-semibold text-gray-700">Nama Paket</th>
                                <th class="p-4 text-sm font-semibold text-gray-700">Berat Sementara (kg)</th>
                                <th class="p-4 text-sm font-semibold text-gray-700">Harga per Kg</th>
                                <th class="p-4 text-sm font-semibold text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan->pesananDetailKiloan as $detail)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="p-4 text-sm text-gray-800">{{ $detail->layananMitraKiloan->layananKiloan->nama_paket }}</td>
                                    <td class="p-4 text-sm text-gray-800">{{ $detail->berat_sementara }}</td>
                                    <td class="p-4 text-sm text-gray-800">Rp {{ number_format($detail->harga_per_kg, 0, ',', '.') }}</td>
                                    <td class="p-4 text-sm text-gray-800">Rp {{ number_format($detail->berat_sementara * $detail->harga_per_kg, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($pesanan->pesananDetailKiloan->first()->berat_final === null)
                    <form action="{{ route('mitra.pesanan.konfirmasi.timbangan', $pesanan) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="berat_final" class="block text-sm font-medium text-gray-700">Berat Final (kg)</label>
                            <input type="number" name="berat_final" class="form-control w-full border rounded-md p-2" step="0.1" min="0.1" required>
                        </div>
                        <button type="submit" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Konfirmasi Timbangan</button>
                    </form>
                @endif
            @else
                <p>Tidak ada detail kiloan.</p>
            @endif

            <h3 class="text-lg font-bold text-gray-700 mb-2 mt-6">Detail Satuan</h3>
            @if ($pesanan->pesananDetailSatuan->isNotEmpty())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Layanan</th>
                            <th>Jumlah Item</th>
                            <th>Harga per Item</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan->pesananDetailSatuan as $detail)
                            <tr>
                                <td>{{ $detail->layananMitraSatuan->layananSatuan->nama_layanan }}</td>
                                <td>{{ $detail->jumlah_item }}</td>
                                <td>Rp {{ number_format($detail->harga_per_item, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->jumlah_item * $detail->harga_per_item, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Tidak ada detail satuan.</p>
            @endif

            <h3 class="text-lg font-bold text-gray-700 mb-2 mt-6">Tagihan</h3>
            @if ($pesanan->tagihan)
                <p><strong>Metode Pembayaran:</strong> {{ $pesanan->tagihan->metode_bayar }}</p>
                <p><strong>Status:</strong> {{ $pesanan->tagihan->status_pembayaran }}</p>
                <p><strong>Jatuh Tempo:</strong> {{ $pesanan->tagihan->jatuh_tempo_pelunasan }}</p>
                <a href="{{ route('mitra.tagihan.show', $pesanan->tagihan) }}" class="btn btn-sm btn-info">Lihat Tagihan</a>
            @else
                <p>Tagihan belum dibuat.</p>
            @endif
        </div>
    </div>
@endsection