@extends('layouts.mitra')

@section('content')
<div class="px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Jadwal Antar & Jemput</h1>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Pelanggan</th>
                        <th class="px-4 py-3 text-left">Jadwal Jemput</th>
                        <th class="px-4 py-3 text-left">Jadwal Antar</th>
                        <th class="px-4 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($jadwals as $i => $jadwal)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                        <td class="px-4 py-2">
                            @if($jadwal->user)
                                {{ $jadwal->user->name }}
                            @elseif($jadwal->walkinCustomer)
                                {{ $jadwal->walkinCustomer->nama }}
                            @else
                                <span class="italic text-gray-400">Tidak diketahui</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($jadwal->opsi_jemput === 'Ya')
                                {{ \Carbon\Carbon::parse($jadwal->jadwal_jemput)->format('d M Y H:i') }}
                            @else
                                <span class="text-gray-400 italic">Tidak dijemput</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($jadwal->opsi_antar === 'Ya')
                                {{ \Carbon\Carbon::parse($jadwal->jadwal_antar)->format('d M Y H:i') }}
                            @else
                                <span class="text-gray-400 italic">Tidak diantar</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @php
                                $now = now();
                                $status = [];

                                if ($jadwal->opsi_jemput === 'Ya') {
                                    $status[] = \Carbon\Carbon::parse($jadwal->jadwal_jemput)->lt($now)
                                        ? 'Terlambat Jemput'
                                        : 'Siap Jemput';
                                }

                                if ($jadwal->opsi_antar === 'Ya') {
                                    $status[] = \Carbon\Carbon::parse($jadwal->jadwal_antar)->lt($now)
                                        ? 'Terlambat Antar'
                                        : 'Siap Antar';
                                }

                                $statusString = implode(' & ', $status);
                            @endphp

                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ Str::contains($statusString, 'Terlambat') ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $statusString ?: 'Tidak ada jadwal' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-6 italic">
                            Tidak ada jadwal antar atau jemput untuk hari ini atau besok.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
