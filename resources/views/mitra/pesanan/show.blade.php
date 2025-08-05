@extends('layouts.mitra')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <div class="bg-white rounded-3xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Pesanan #{{ $pesanan->id }}</h1>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="space-y-3 mb-6">
            <p><span class="font-semibold text-gray-700">Pelanggan:</span> {{ $pesanan->user ? $pesanan->user->name : $pesanan->walkinCustomer->nama }}</p>
            <p><span class="font-semibold text-gray-700">Jenis Pesanan:</span> {{ $pesanan->jenis_pesanan ?: 'Tidak Diketahui' }}</p>
            <p><span class="font-semibold text-gray-700">Tanggal Pesan:</span> {{ $pesanan->tanggal_pesan }}</p>
            <p><span class="font-semibold text-gray-700">Status:</span> {{ $pesanan->trackingStatus->last()->statusMaster->nama_status ?? 'Menunggu' }}</p>
            <p><span class="font-semibold text-gray-700">DP Wajib:</span> {{ $pesanan->tipe_dp_wajib }}</p>
            <p><span class="font-semibold text-gray-700">Bisa Lunas:</span> {{ $pesanan->tipe_bisa_lunas }}</p>
            <p><span class="font-semibold text-gray-700">Catatan Pesanan:</span> {{ $pesanan->catatan_pesanan ?? '-' }}</p>
            <p><span class="font-semibold text-gray-700">Opsi Jemput:</span> {{ $pesanan->opsi_jemput }}</p>
            <p><span class="font-semibold text-gray-700">Jadwal Jemput:</span> {{ $pesanan->jadwal_jemput ?? '-' }}</p>
            <p><span class="font-semibold text-gray-700">Opsi Antar:</span> {{ $pesanan->opsi_antar }}</p>
            <p><span class="font-semibold text-gray-700">Jadwal Antar:</span> {{ $pesanan->jadwal_antar ?? '-' }}</p>
            <p><span class="font-semibold text-gray-700">Catatan Pengiriman:</span> {{ $pesanan->catatan_pengiriman ?? '-' }}</p>
        </div>

        @if ($pesanan->pesananDetailKiloan->isNotEmpty())
            <h3 class="text-lg font-bold text-gray-700 mb-2">Detail Kiloan</h3>
            <div class="overflow-x-auto mb-6">
                <table class="w-full text-left rounded-xl overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 text-sm font-semibold text-gray-700">Nama Paket</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Berat (kg)</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Harga per Kg</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan->pesananDetailKiloan as $detail)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-4 text-sm text-gray-800">{{ $detail->layananMitraKiloan->layananKiloan->nama_paket }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $detail->berat_final ?? $detail->berat_sementara }} kg</td>
                                <td class="p-4 text-sm text-gray-800">Rp {{ number_format($detail->harga_per_kg, 0, ',', '.') }}</td>
                                <td class="p-4 text-sm text-gray-800">Rp {{ number_format($detail->subtotal ?? ($detail->berat_sementara * $detail->harga_per_kg), 0, ',', '.') }}</td>
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
                        <input type="number" name="berat_final" class="form-control w-full border rounded-md p-2 focus:ring-green-500 focus:border-green-500" step="0.1" min="0.1" required>
                        @error('berat_final')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Konfirmasi Timbangan</button>
                </form>
            @endif
        @endif

        @if ($pesanan->pesananDetailSatuan->isNotEmpty())
            <h3 class="text-lg font-bold text-gray-700 mb-2 mt-6">Detail Satuan</h3>
            <table class="w-full text-left rounded-xl overflow-hidden mb-6">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-700">Nama Layanan</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Jumlah Item</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Harga per Item</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanan->pesananDetailSatuan as $detail)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-4 text-sm text-gray-800">{{ $detail->layananMitraSatuan->layananSatuan->nama_layanan }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $detail->jumlah_item }}</td>
                            <td class="p-4 text-sm text-gray-800">Rp {{ number_format($detail->harga_per_item, 0, ',', '.') }}</td>
                            <td class="p-4 text-sm text-gray-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <h3 class="text-lg font-bold text-gray-700 mb-2 mt-6">Tagihan</h3>
        @if ($pesanan->tagihan)
            <p><strong>Total Tagihan:</strong> Rp {{ number_format($pesanan->tagihan->total_tagihan ?? 0, 0, ',', '.') }}</p>
            <p><strong>DP Dibayar:</strong> Rp {{ number_format($pesanan->tagihan->dp_dibayar, 0, ',', '.') }}</p>
            <p><strong>Sisa Tagihan:</strong> Rp {{ number_format($pesanan->tagihan->sisa_tagihan ?? 0, 0, ',', '.') }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ $pesanan->tagihan->metode_bayar }}</p>
            <p><strong>Status:</strong> {{ $pesanan->tagihan->status_pembayaran }}</p>
            <p><strong>Jatuh Tempo:</strong> {{ $pesanan->tagihan->jatuh_tempo_pelunasan ?? '-' }}</p>
            <p><strong>Waktu Pelunasan:</strong> {{ $pesanan->tagihan->waktu_pelunasan ?? '-' }}</p>
            <a href="{{ route('mitra.tagihan.show', $pesanan->tagihan) }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-medium mt-2">Lihat Tagihan</a>
        @else
            <p>Tagihan belum dibuat.</p>
        @endif
    </div>
</div>
@endsection