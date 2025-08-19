{{-- resources/views/mitra/pesanan/show.blade.php --}}
@extends('layouts.mitra')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">

    {{-- Informasi Utama Pesanan --}}
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Informasi Pesanan</h2>
        
        <div class="grid md:grid-cols-2 gap-6 text-gray-700">
            <div>
                <p class="mb-2"><span class="font-semibold">Pelanggan:</span><br>
                    @if($pesanan->user)
                        <span class="block font-medium">{{ $pesanan->user->name ?? '—' }}</span>
                        <small class="block text-gray-500">{{ $pesanan->user->pelangganProfile->no_telepon ?? '-' }}</small>
                        <small class="block text-gray-500">{{ $pesanan->user->pelangganProfile->alamat ?? '-' }}</small>
                    @elseif($pesanan->walkinCustomer)
                        <span class="block font-medium">{{ $pesanan->walkinCustomer->name ?? '—' }}</span>
                        <small class="block text-gray-500">{{ $pesanan->walkinCustomer->no_telepon ?? '-' }}</small>
                        <small class="block text-gray-500">{{ $pesanan->walkinCustomer->alamat ?? '-' }}</small>
                    @else
                        —
                    @endif
                </p>

                <p class="mb-2"><span class="font-semibold">ID Pesanan:</span> {{ $pesanan->id }}</p>
                <p class="mb-2"><span class="font-semibold">Mitra:</span> {{ $pesanan->mitra->nama_toko ?? '-' }}</p>
                <p class="mb-2"><span class="font-semibold">Jenis Pesanan:</span> {{ $pesanan->jenis_pesanan }}</p>
                <p class="mb-2"><span class="font-semibold">Catatan Pesanan:</span> {{ $pesanan->catatan_pesanan ?? '-' }}</p>
            </div>

            <div>
                <p class="mb-2"><span class="font-semibold">Tipe DP Wajib:</span> {{ $pesanan->tipe_dp_wajib ?? '-' }}</p>
                <p class="mb-2"><span class="font-semibold">Tipe Bisa Lunas:</span> {{ $pesanan->tipe_bisa_lunas ?? '-' }}</p>
                <p class="mb-2"><span class="font-semibold">Tanggal Pesan:</span> {{ $pesanan->tanggal_pesan ? \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y H:i') : '-' }}</p>

                <p class="mb-2"><span class="font-semibold">Opsi Jemput:</span> {{ $pesanan->opsi_jemput ?? '-' }}
                    @if($pesanan->jadwal_jemput)
                        <small class="text-gray-500">({{ \Carbon\Carbon::parse($pesanan->jadwal_jemput)->format('d M Y H:i') }})</small>
                    @endif
                </p>
                <p class="mb-2"><span class="font-semibold">Opsi Antar:</span> {{ $pesanan->opsi_antar ?? '-' }}
                    @if($pesanan->jadwal_antar)
                        <small class="text-gray-500">({{ \Carbon\Carbon::parse($pesanan->jadwal_antar)->format('d M Y H:i') }})</small>
                    @endif
                </p>
                <p class="mb-2"><span class="font-semibold">Catatan Pengiriman:</span> {{ $pesanan->catatan_pengiriman ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Detail Kiloan --}}
    @if($pesanan->kiloanDetails->count())
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Detail Kiloan</h3>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left">Layanan</th>
                            <th class="px-4 py-2">Berat Sementara</th>
                            <th class="px-4 py-2">Berat Final</th>
                            <th class="px-4 py-2">Harga/Kg</th>
                            <th class="px-4 py-2">Subtotal</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pesanan->kiloanDetails as $detail)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $detail->layananMitraKiloan->layananKiloan->nama_layanan }}</td>
                                <td class="px-4 py-2 text-center">{{ $detail->berat_sementara ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">{{ $detail->berat_final ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">Rp{{ number_format($detail->harga_per_kg,0,',','.') }}</td>
                                <td class="px-4 py-2 text-center">Rp{{ number_format($detail->subtotal,0,',','.') }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if(is_null($detail->berat_final))
                                        @if($pesanan->tagihan && $pesanan->tagihan->dp_dibayar > 0)
                                            <form action="{{ route('mitra.pesanan.updateTimbangan', $detail->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                                @csrf
                                                <input type="number" name="berat_final" min="0.1" step="0.1" class="border border-gray-300 rounded-lg p-1 w-20 text-center" required>
                                                <button type="submit" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs">Simpan</button>
                                            </form>
                                        @else
                                            <span class="text-red-600 text-sm">DP belum dibayar</span>
                                        @endif
                                    @else
                                        <span class="text-green-600 text-sm font-semibold">✔️ Sudah dikonfirmasi</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Detail Satuan --}}
    @if($pesanan->satuanDetails->count())
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Detail Satuan</h3>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left">Layanan</th>
                            <th class="px-4 py-2">Jumlah Item</th>
                            <th class="px-4 py-2">Harga/Item</th>
                            <th class="px-4 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pesanan->satuanDetails as $detail)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $detail->layananMitraSatuan->layananSatuan->nama_layanan }}</td>
                                <td class="px-4 py-2 text-center">{{ $detail->jumlah_item }}</td>
                                <td class="px-4 py-2 text-center">Rp{{ number_format($detail->harga_per_item,0,',','.') }}</td>
                                <td class="px-4 py-2 text-center">Rp{{ number_format($detail->subtotal,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Ringkasan Tagihan --}}
    @if($pesanan->tagihan)
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Ringkasan Tagihan</h3>
            <div class="grid md:grid-cols-2 gap-6 text-gray-700">
                <p><span class="font-semibold">Total Tagihan:</span> Rp{{ number_format($pesanan->tagihan->total_tagihan,0,',','.') }}</p>
                <p><span class="font-semibold">DP Dibayar:</span> Rp{{ number_format($pesanan->tagihan->dp_dibayar,0,',','.') }}</p>
                <p><span class="font-semibold">Sisa Tagihan:</span> Rp{{ number_format($pesanan->tagihan->sisa_tagihan,0,',','.') }}</p>
                <p><span class="font-semibold">Status:</span> 
                    @if($pesanan->tagihan->status_pembayaran === 'lunas')
                        <span class="text-green-600 font-semibold">Sudah Lunas</span>
                    @else
                        <span class="text-red-600 font-semibold">Belum Lunas</span>
                    @endif
                </p>
            </div>
        </div>
    @endif
</div>
@endsection
