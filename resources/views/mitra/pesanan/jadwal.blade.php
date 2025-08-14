@extends('layouts.mitra')

@section('title', 'Jadwal Antar & Jemput')

@section('content')
<div class="p-4 max-w-6xl mx-auto">
    <h2 class="text-2xl font-semibold mb-4">Jadwal Antar & Jemput</h2>

    <div class="bg-white shadow rounded p-4">
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Pelanggan</th>
                    <th class="p-2 border">Jemput</th>
                    <th class="p-2 border">Antar</th>
                    <th class="p-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $j)
                    <tr>
                        <td class="p-2 border">
                            {{ $j->user->profile->nama_lengkap ?? $j->walkinCustomer->nama ?? '-' }}
                        </td>
                        <td class="p-2 border">{{ $j->jadwal_jemput ?? '-' }}</td>
                        <td class="p-2 border">{{ $j->jadwal_antar ?? '-' }}</td>
                        <td class="p-2 border">
                            {{ ucfirst(str_replace('_',' ', $j->trackingStatus->last()->statusMaster->nama_status ?? '')) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-2 text-center text-gray-500">Tidak ada jadwal</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
