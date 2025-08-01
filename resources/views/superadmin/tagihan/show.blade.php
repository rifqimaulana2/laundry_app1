<!-- resources/views/superadmin/tagihan/show.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="container">
        <h1>Detail Tagihan #{{ $tagihan->id }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Pesanan ID:</strong> {{ $tagihan->pesanan->id }}</p>
                <p><strong>Pelanggan:</strong> {{ $tagihan->pesanan->user ? $tagihan->pesanan->user->name : $tagihan->pesanan->walkinCustomer->nama }}</p>
                <p><strong>Mitra:</strong> {{ $tagihan->pesanan->mitra->nama_toko }}</p>
                <p><strong>Total Tagihan:</strong> Rp {{ number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') }}</p>
                <p><strong>DP Dibayar:</strong> Rp {{ number_format($tagihan->dp_dibayar ?? 0, 0, ',', '.') }}</p>
                <p><strong>Sisa Tagihan:</strong> Rp {{ number_format($tagihan->sisa_tagihan ?? 0, 0, ',', '.') }}</p>
                <p><strong>Metode Bayar:</strong> {{ $tagihan->metode_bayar }}</p>
                <p><strong>Status Pembayaran:</strong> {{ $tagihan->status_pembayaran }}</p>
                <p><strong>Jatuh Tempo:</strong> {{ $tagihan->jatuh_tempo_pelunasan }}</p>
                <h3>Detail Pesanan</h3>
                <h4>Kiloan</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Berat Final</th>
                            <th>Harga per Kg</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tagihan->pesanan->pesananDetailKiloan as $detail)
                            <tr>
                                <td>{{ $detail->layananMitraKiloan->layananKiloan->nama_paket }}</td>
                                <td>{{ $detail->berat_final ?? $detail->berat_sementara }} kg</td>
                                <td>Rp {{ number_format($detail->harga_per_kg, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal ?? ($detail->berat_final * $detail->harga_per_kg), 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h4>Satuan</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Jumlah Item</th>
                            <th>Harga per Item</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tagihan->pesanan->pesananDetailSatuan as $detail)
                            <tr>
                                <td>{{ $detail->layananMitraSatuan->layananSatuan->nama_layanan }}</td>
                                <td>{{ $detail->jumlah_item }}</td>
                                <td>Rp {{ number_format($detail->harga_per_item, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal ?? ($detail->jumlah_item * $detail->harga_per_item), 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection