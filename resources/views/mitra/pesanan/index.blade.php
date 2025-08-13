@extends('layouts.mitra')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Daftar Pesanan</h2>
        <a href="{{ route('mitra.pesanan.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
            + Buat Pesanan
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm border border-gray-200">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 border">ID</th>
                    <th class="p-3 border">Pelanggan</th>
                    <th class="p-3 border">Jenis</th>
                    <th class="p-3 border">Tanggal</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Tagihan</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanans as $pesanan)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border">{{ $pesanan->id }}</td>
                        <td class="p-3 border">
                            {{ $pesanan->pelangganProfile->nama_lengkap ?? $pesanan->walkinCustomer->nama ?? '-' }}
                        </td>
                        <td class="p-3 border">{{ $pesanan->jenis_pesanan }}</td>
                        <td class="p-3 border">{{ $pesanan->tanggal_pesan }}</td>
                        <td class="p-3 border">
                            <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
                                {{ $pesanan->trackingStatus->last()?->statusMaster?->nama_status ?? '-' }}
                            </span>
                        </td>
                        <td class="p-3 border font-semibold text-green-700">
                            Rp{{ number_format($pesanan->tagihan->total_tagihan ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="p-3 border">
                            <a href="{{ route('mitra.pesanan.show', $pesanan->id) }}" class="text-blue-500 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-3 border text-center text-gray-500">Belum ada pesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
