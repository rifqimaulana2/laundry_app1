@extends('layouts.mitra')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="p-4 max-w-7xl mx-auto">
    <h2 class="text-2xl font-semibold mb-4">Daftar Pesanan</h2>

    <a href="{{ route('mitra.pesanan.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Pesanan</a>

    <div class="bg-white shadow rounded p-4">
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">Pelanggan</th>
                    <th class="p-2 border">Jenis Pesanan</th>
                    <th class="p-2 border">Total Tagihan</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $pesanan)
                    <tr>
                        <td class="p-2 border">{{ $pesanan->id }}</td>
                        <td class="p-2 border">
                            {{ $pesanan->user->profile->nama_lengkap
                                ?? $pesanan->walkinCustomer->nama
                                ?? '-' }}
                        </td>
                        <td class="p-2 border">{{ $pesanan->jenis_pesanan }}</td>
                        <td class="p-2 border">
                            Rp{{ number_format($pesanan->tagihan->total_tagihan ?? 0,0,',','.') }}
                        </td>
                        <td class="p-2 border">
                            {{ ucfirst(str_replace('_', ' ', $pesanan->tagihan->status_pembayaran ?? 'belum lunas')) }}
                        </td>
                        <td class="p-2 border text-center">
                            <a href="{{ route('mitra.pesanan.show', $pesanan->id) }}" 
                               class="bg-blue-600 text-white px-3 py-1 rounded text-xs">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-2 text-center text-gray-500">Belum ada pesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
