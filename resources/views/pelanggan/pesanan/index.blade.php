@extends('layouts.pelanggan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-2xl shadow-xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">📋 Daftar Pesanan Anda</h1>

        @if ($pesanans->isEmpty())
            <div class="text-center py-10">
                <p class="text-gray-500 text-lg">Belum ada pesanan dibuat.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                    <thead class="bg-blue-100 text-gray-700 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">Mitra</th>
                            <th class="px-5 py-3">Jenis Pesanan</th>
                            <th class="px-5 py-3">Tanggal Pesan</th>
                            <th class="px-5 py-3">Kiloan Sementara</th>
                            <th class="px-5 py-3">Kiloan Final</th>
                            <th class="px-5 py-3">Status Pembayaran</th>
                            <th class="px-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($pesanans as $pesanan)
                            @php
                                $beratSementara = $pesanan->kiloanDetails->sum('berat_sementara');
                                $beratFinal = $pesanan->kiloanDetails->sum('berat_final');
                                $status = strtolower($pesanan->tagihan->status_pembayaran);
                            @endphp
                            <tr class="hover:bg-gray-50 transition-all duration-200">
                                <td class="px-5 py-3 font-medium text-gray-700">{{ $pesanan->id }}</td>
                                <td class="px-5 py-3 text-gray-900">{{ $pesanan->mitra->nama_toko }}</td>
                                <td class="px-5 py-3 text-gray-700">{{ $pesanan->jenis_pesanan ?? '-' }}</td>
                                <td class="px-5 py-3 text-gray-700">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}</td>
                                <td class="px-5 py-3">{{ $beratSementara }} kg</td>
                                <td class="px-5 py-3">{{ $beratFinal ?? '-' }} kg</td>
                                <td class="px-5 py-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if ($status === 'lunas') bg-green-100 text-green-700
                                        @elseif ($status === 'belum lunas') bg-yellow-100 text-yellow-700
                                        @else bg-gray-100 text-gray-600
                                        @endif">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <a href="{{ route('pelanggan.pesanan.show', $pesanan->id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-4 py-2 rounded-full shadow transition duration-150">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
