@extends('layouts.employee')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">🧾 Daftar Tagihan</h1>

    <div class="overflow-x-auto">
        <table class="w-full table-auto border rounded">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">ID Pesanan</th>
                    <th class="px-4 py-2">Pelanggan</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tagihans as $tagihan)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $tagihan->id }}</td>
                        <td class="border px-4 py-2">{{ $tagihan->pesanan_id }}</td>
                        <td class="border px-4 py-2">
                            {{ $tagihan->pesanan->user->name ?? $tagihan->pesanan->walkinCustomer->nama ?? '-' }}
                        </td>
                        <td class="border px-4 py-2">Rp{{ number_format($tagihan->total_tagihan ?? 0) }}</td>
                        <td class="border px-4 py-2">{{ $tagihan->status_pembayaran }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('employee.tagihan.show', $tagihan) }}" class="text-blue-600 hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">Belum ada tagihan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
