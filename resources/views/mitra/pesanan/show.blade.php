@extends('layouts.mitra')

@section('title', 'Detail Pesanan')

@section('content')
<div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow space-y-6">

    {{-- HEADER --}}
    <h1 class="text-2xl font-bold">
        Detail Pesanan #{{ $pesanan->id }}
    </h1>

    {{-- INFORMASI PESANAN --}}
    <div>
        <h2 class="text-lg font-semibold mb-2">Informasi Pesanan</h2>
        <div class="border rounded p-4 bg-gray-50 space-y-1">
            <p><strong>Pelanggan:</strong>
                {{ optional(optional($pesanan->user)->profile)->nama_lengkap
                    ?? optional($pesanan->walkinCustomer)->nama
                    ?? '-' }}
            </p>
            <p><strong>Jenis Pesanan:</strong> {{ $pesanan->jenis_pesanan }}</p>
            <p><strong>Tanggal Pesan:</strong> {{ $pesanan->tanggal_pesan }}</p>
            <p><strong>Opsi Jemput:</strong> {{ $pesanan->opsi_jemput }}</p>
            <p><strong>Opsi Antar:</strong> {{ $pesanan->opsi_antar }}</p>
        </div>
    </div>

    {{-- DETAIL LAYANAN --}}
    <div>
        <h2 class="text-lg font-semibold mb-2">Detail Layanan</h2>

        {{-- Kiloan --}}
        @if(($pesanan->kiloanDetails ?? collect())->count())
        <h3 class="font-bold mt-2">Kiloan</h3>
        <table class="w-full border text-sm mb-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Layanan</th>
                    <th class="p-2 border">Berat (kg)</th>
                    <th class="p-2 border">Harga/kg</th>
                    <th class="p-2 border">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->kiloanDetails as $item)
                    <tr>
                        <td class="p-2 border">{{ optional($item->layananKiloan)->nama_layanan ?? '-' }}</td>
                        <td class="p-2 border">{{ $item->berat_final ?? $item->berat }} kg</td>
                        <td class="p-2 border">Rp{{ number_format($item->harga_per_kg,0,',','.') }}</td>
                        <td class="p-2 border">Rp{{ number_format($item->subtotal,0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        {{-- Satuan --}}
        @if(($pesanan->detailSatuan ?? collect())->count())
        <h3 class="font-bold mt-2">Satuan</h3>
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Layanan</th>
                    <th class="p-2 border">Jumlah</th>
                    <th class="p-2 border">Harga/item</th>
                    <th class="p-2 border">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->detailSatuan as $item)
                    <tr>
                        <td class="p-2 border">{{ optional($item->layananSatuan)->nama_layanan ?? '-' }}</td>
                        <td class="p-2 border">{{ $item->jumlah }}</td>
                        <td class="p-2 border">Rp{{ number_format($item->harga_per_item,0,',','.') }}</td>
                        <td class="p-2 border">Rp{{ number_format($item->subtotal,0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- FORM INPUT BERAT FINAL --}}
    @if($pesanan->jenis_pesanan !== 'Satuan')
    <div>
        <h2 class="text-lg font-semibold mb-2">Input Timbangan Real</h2>
        <form action="{{ route('mitra.pesanan.konfirmasiTimbangan', $pesanan->id) }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block font-medium">Berat Final (kg)</label>
                <input type="number" step="0.1" name="berat_final" class="border rounded p-2 w-full" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Berat</button>
        </form>
    </div>
    @endif

    {{-- INFO TAGIHAN --}}
    <div>
        <h2 class="text-lg font-semibold mb-2">Tagihan</h2>
        <div class="border rounded p-4 bg-gray-50 space-y-1">
            <p><strong>Total Tagihan:</strong> Rp{{ number_format(optional($pesanan->tagihan)->total_tagihan ?? 0,0,',','.') }}</p>
            <p><strong>DP Dibayar:</strong> Rp{{ number_format(optional($pesanan->tagihan)->dp_dibayar ?? 0,0,',','.') }}</p>
            <p><strong>Sisa Tagihan:</strong> Rp{{ number_format(optional($pesanan->tagihan)->sisa_tagihan ?? 0,0,',','.') }}</p>
            <p><strong>Status Pembayaran:</strong> {{ ucfirst(str_replace('_',' ', optional($pesanan->tagihan)->status_pembayaran ?? '-')) }}</p>
        </div>
    </div>

    {{-- RIWAYAT TRANSAKSI --}}
    <div>
        <h2 class="text-lg font-semibold mb-2">Riwayat Pembayaran</h2>
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Nominal</th>
                    <th class="p-2 border">Jenis Transaksi</th>
                    <th class="p-2 border">Metode Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse(optional($pesanan->tagihan)->riwayatTransaksi ?? [] as $r)
                    <tr>
                        <td class="p-2 border">{{ $r->created_at }}</td>
                        <td class="p-2 border">Rp{{ number_format($r->nominal,0,',','.') }}</td>
                        <td class="p-2 border">{{ ucfirst($r->jenis_transaksi) }}</td>
                        <td class="p-2 border">{{ ucfirst($r->metode_bayar) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-2 text-center text-gray-500">Belum ada pembayaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- FORM TAMBAH PEMBAYARAN --}}
    @if((optional($pesanan->tagihan)->sisa_tagihan ?? 0) > 0)
    <div>
        <h2 class="text-lg font-semibold mb-2">Tambah Pembayaran</h2>
        <form action="{{ route('mitra.pesanan.tambahPembayaran', $pesanan->tagihan->id) }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block font-medium">Nominal</label>
                <input type="number" name="nominal" class="border rounded p-2 w-full" required>
            </div>
            <div>
                <label class="block font-medium">Jenis Transaksi</label>
                <select name="jenis_transaksi" class="border rounded p-2 w-full">
                    <option value="dp">DP</option>
                    <option value="pelunasan">Pelunasan</option>
                </select>
            </div>
            <div>
                <label class="block font-medium">Metode Bayar</label>
                <select name="metode_bayar" class="border rounded p-2 w-full">
                    <option value="transfer">Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="tunai">Tunai</option>
                </select>
            </div>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Simpan Pembayaran
            </button>
        </form>
    </div>
    @endif

    {{-- UPDATE STATUS ANTAR/JEMPUT --}}
    <div>
        <h2 class="text-lg font-semibold mb-2">Update Status Pesanan</h2>
        <form action="{{ route('mitra.pesanan.updateStatus', $pesanan->id) }}" method="POST">
            @csrf
            <select name="status_master_id" class="border rounded p-2 w-full mb-2">
                @foreach($statusList as $status)
                    <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">
                Update Status
            </button>
        </form>
    </div>

    {{-- TOMBOL KEMBALI --}}
    <a href="{{ route('mitra.pesanan.index') }}" class="px-4 py-2 border rounded">Kembali</a>
</div>
@endsection
