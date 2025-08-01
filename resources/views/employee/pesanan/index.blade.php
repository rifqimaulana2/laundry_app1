@extends('layouts.employee')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">📦 Daftar Pesanan</h1>
    <div class="overflow-x-auto">
        <table class="w-full table-auto border rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Pelanggan</th>
                    <th class="px-4 py-2">Jenis Pesanan</th>
                    <th class="px-4 py-2">Tanggal Pesan</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanans as $pesanan)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $pesanan->id }}</td>
                        <td class="border px-4 py-2">
                            {{ $pesanan->user->name ?? $pesanan->walkinCustomer->nama }}
                        </td>
                        <td class="border px-4 py-2">{{ $pesanan->jenis_pesanan }}</td>
                        <td class="border px-4 py-2">{{ $pesanan->tanggal_pesan }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('employee.pesanan.show', $pesanan) }}"
                               class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
