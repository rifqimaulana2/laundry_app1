@extends('layouts.admin')

@section('title', 'Notifikasi Sistem')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Notifikasi Sistem</h1>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-3">Tipe</th>
                    <th class="px-4 py-3">Pesan</th>
                    <th class="px-4 py-3">Untuk</th>
                    <th class="px-4 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifikasis as $notif)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2 capitalize">{{ $notif->tipe }}</td>
                    <td class="px-4 py-2">{{ $notif->pesan }}</td>
                    <td class="px-4 py-2">{{ ucfirst($notif->untuk) }}</td>
                    <td class="px-4 py-2">{{ $notif->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
