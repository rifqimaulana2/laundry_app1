<!-- resources/views/superadmin/pesanan/show.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="container">
        <h1>Detail Pesanan #{{ $pesanan->id }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Pelanggan:</strong> {{ $pesanan->user ? $pesanan->user->name : $pesanan->walkinCustomer->nama }}</p>
                <p><strong>Mitra:</strong> {{ $pesanan->mitra->nama_toko }}</p>
                <p><strong>Jenis Pesanan:</strong> {{ $pesanan->jenis_pesanan }}</p>
                <p><strong>Tanggal Pesan:</strong> {{ $pesanan->tanggal_pesan }}</p>
                <p><strong>Status:</strong> {{ $pesanan->status_pesanan ?? 'Menunggu' }}</p>
                <p><strong>Catatan:</strong> {{ $pesanan->catatan_pesanan }}</p>
                <p><strong>Opsi Jemput:</strong> {{ $pesanan->opsi_jemput }}</p>
                <p><strong>Jadwal Jemput:</strong> {{ $pesanan->jadwal_jemput }}</p>
                <p><strong>Opsi Antar:</strong> {{ $pesanan->opsi_antar }}</p>
                <p><strong>Jadwal Antar:</strong> {{ $pesanan->jadwal_antar }}</p>
                <h3>Detail Kiloan</h3>
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
                        @foreach ($pesanan->pesananDetailKiloan as $detail)
                            <tr>
                                <td>{{ $detail->layananMitraKiloan->layananKiloan->nama_paket }}</td>
                                <td>{{ $detail->berat_final ?? $detail->berat_sementara }} kg</td>
                                <td>Rp {{ number_format($detail->harga_per_kg, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal ?? ($detail->berat_final * $detail->harga_per_kg), 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3>Detail Satuan</h3>
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
                        @foreach ($pesanan->pesananDetailSatuan as $detail)
                            <tr>
                                <td>{{ $detail->layananMitraSatuan->layananSatuan->nama_layanan }}</td>
                                <td>{{ $detail->jumlah_item }}</td>
                                <td>Rp {{ number_format($detail->harga_per_item, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal ?? ($detail->jumlah_item * $detail->harga_per_item), 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3>Tagihan</h3>
                <p><strong>Total Tagihan:</strong> Rp {{ number_format($pesanan->tagihan->total_tagihan ?? 0, 0, ',', '.') }}</p>
                <p><strong>DP Dibayar:</strong> Rp {{ number_format($pesanan->tagihan->dp_dibayar ?? 0, 0, ',', '.') }}</p>
                <p><strong>Sisa Tagihan:</strong> Rp {{ number_format($pesanan->tagihan->sisa_tagihan ?? 0, 0, ',', '.') }}</p>
                <p><strong>Status Pembayaran:</strong> {{ $pesanan->tagihan->status_pembayaran }}</p>
            </div>
        </div>
    </div>
@endsection