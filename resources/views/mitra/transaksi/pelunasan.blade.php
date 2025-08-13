@extends('layouts.mitra')

@section('title', 'Pelunasan Tagihan')

@section('content')
<div class="p-4 max-w-lg mx-auto">
    <h2 class="text-xl font-semibold mb-4">Pelunasan Tagihan</h2>

    <div class="bg-white shadow rounded p-4 mb-6">
        <h3 class="font-bold mb-2">Detail Tagihan</h3>
        <p><strong>Pelanggan:</strong> 
            {{ $tagihan->pesanan->pelangganProfile->nama_lengkap 
                ?? $tagihan->pesanan->walkinCustomer->nama 
                ?? '-' }}
        </p>
        <p><strong>Total:</strong> Rp{{ number_format($tagihan->total_tagihan,0,',','.') }}</p>
        <p><strong>DP Dibayar:</strong> Rp{{ number_format($tagihan->dp_dibayar,0,',','.') }}</p>
        <p><strong>Sisa Tagihan:</strong> Rp{{ number_format($tagihan->sisa_tagihan,0,',','.') }}</p>
        <p><strong>Status:</strong> {{ ucfirst(str_replace('_',' ', $tagihan->status_pembayaran)) }}</p>
    </div>

    <div class="bg-white shadow rounded p-4">
        <h3 class="font-bold mb-2">Form Pelunasan</h3>
        <form action="{{ route('mitra.transaksi.store', $tagihan->id) }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block font-medium">Nominal</label>
                <input type="number" name="nominal" class="border rounded p-2 w-full" 
                       value="{{ $tagihan->sisa_tagihan }}" required>
            </div>
            <div>
                <label class="block font-medium">Jenis Transaksi</label>
                <select name="jenis_transaksi" class="border rounded p-2 w-full">
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
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                Bayar Sekarang
            </button>
        </form>
    </div>
</div>
@endsection
