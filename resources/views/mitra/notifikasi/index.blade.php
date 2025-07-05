@extends('layouts.mitra')

@section('title', 'Notifikasi')

@section('content')
<h1 class="text-xl font-semibold mb-4">Notifikasi Masuk</h1>

<table class="table-auto w-full bg-white shadow rounded">
    <thead class="bg-blue-100">
        <tr>
            <th class="p-2">Judul</th>
            <th class="p-2">Aktivitas</th>
            <th class="p-2">Status</th>
            <th class="p-2">Waktu</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($notifikasi as $notif)
        <tr class="border-t">
            <td class="p-2">{{ $notif->judul }}</td>
            <td class="p-2">{{ $notif->aktivitas }}</td>
            <td class="p-2">
                {!! $notif->status_baca ? '<span class="text-green-600">Dibaca</span>' : '<span class="text-yellow-600">Baru</span>' !!}
            </td>
            <td class="p-2">{{ $notif->created_at->format('d M Y H:i') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center p-4">Tidak ada notifikasi.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
