@extends('layouts.mitra')

@section('title', 'Jadwal Antar & Jemput')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Jadwal Antar & Jemput</h2>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm border border-gray-200">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 border">ID</th>
                    <th class="p-3 border">Pelanggan</th>
                    <th class="p-3 border">Jenis</th>
                    <th class="p-3 border">Jadwal Jemput</th>
                    <th class="p-3 border">Jadwal Antar</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border">{{ $p->id }}</td>
                        <td class="p-3 border">
                            {{ $p->pelangganProfile->nama_lengkap ?? $p->walkinCustomer->nama ?? '-' }}
                        </td>
                        <td class="p-3 border">{{ $p->jenis_pesanan }}</td>
                        <td class="p-3 border">{{ $p->jadwal_jemput ?? '-' }}</td>
                        <td class="p-3 border">{{ $p->jadwal_antar ?? '-' }}</td>
                        <td class="p-3 border">
                            <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">
                                {{ $p->trackingStatus->last()?->statusMaster?->nama_status ?? '-' }}
                            </span>
                        </td>
                        <td class="p-3 border">
                            <a href="{{ route('mitra.pesanan.show', $p->id) }}" class="text-blue-500 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-3 border text-center text-gray-500">Tidak ada jadwal antar/jemput</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
