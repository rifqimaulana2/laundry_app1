@extends('layouts.mitra')

@section('title', 'Detail Transaksi')

@section('content')
<div class="p-6 max-w-5xl mx-auto bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">
        Detail Transaksi Pesanan #{{ $pesanan->id }}
    </h1>

    {{-- INFORMASI PESANAN --}}
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Informasi Pesanan</h2>
        <div class="border rounded p-4 bg-gray-50">
            <p><strong>Pelanggan:</strong>
                {{ $pesanan->pelangganProfile->nama_lengkap
                    ?? $pesanan->walkinCustomer->nama
                    ?? '-' }}
            </p>
            <p><strong>Jenis Pesanan:</strong> {{ $pesanan->jenis_pesanan }}</p>
            <p><strong>Tanggal Pesan:</strong> {{ $pesanan->tanggal_pesan }}</p>
        </div>
    </div>

    {{-- TAGIHAN --}}
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Tagihan</h2>
        <div class="border rounded p-4 bg-gray-50">
            <p><strong>Total Tagihan:</strong> Rp{{ number_format($pesanan->tagihan->total_tagihan ?? 0,0,',','.') }}</p>
            <p><strong>DP Dibayar:</strong> Rp{{ number_format($pesanan->tagihan->dp_dibayar ?? 0,0,',','.') }}</p>
            <p><strong>Sisa Tagihan:</strong> Rp{{ number_format($pesanan->tagihan->sisa_tagihan ?? 0,0,',','.') }}</p>
            <p><strong>Status Pembayaran:</strong> {{ ucfirst(str_replace('_',' ', $pesanan->tagihan->status_pembayaran ?? '-')) }}</p>
        </div>
    </div>

    {{-- RIWAYAT TRANSAKSI --}}
    <div class="mb-6">
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
                @forelse($pesanan->tagihan->riwayatTransaksi ?? [] as $r)
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
    @if(($pesanan->tagihan->sisa_tagihan ?? 0) > 0)
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Tambah Pembayaran</h2>
        <form action="{{ route('mitra.transaksi.store', $pesanan->tagihan->id) }}" method="POST" class="space-y-3">
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

    <a href="{{ route('mitra.transaksi.index') }}" class="px-4 py-2 border rounded">Kembali</a>
</div>
@endsection
