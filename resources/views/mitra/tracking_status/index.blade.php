@extends('layouts.mitra')

@section('title', 'Tracking Status')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Tracking Status</h1>

    <div class="bg-white p-4 rounded shadow">
        <table class="w-full table-auto mt-2">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Kode Pesanan</th>
                    <th class="px-4 py-2 text-left">Status Terakhir</th>
                    <th class="px-4 py-2 text-left">Waktu Update</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanans as $i => $pesanan)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                        <td class="px-4 py-2">{{ $pesanan->kode ?? '-' }}</td>
                        <td class="px-4 py-2">
                            {{ $pesanan->latestTrackingStatus->status ?? 'Belum ada' }}
                        </td>
                        <td class="px-4 py-2">
                            {{ optional($pesanan->latestTrackingStatus)->updated_at?->format('d M Y H:i') ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada data tracking.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
