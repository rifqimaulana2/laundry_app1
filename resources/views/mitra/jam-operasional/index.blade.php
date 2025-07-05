@extends('layouts.mitra')

@section('title', 'Jam Operasional')

@section('content')
<h1 class="text-xl font-semibold mb-4">Jam Operasional</h1>

<table class="table-auto w-full bg-white shadow rounded">
    <thead class="bg-blue-100">
        <tr>
            <th class="p-2">Hari</th>
            <th class="p-2">Jam Buka</th>
            <th class="p-2">Jam Tutup</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($jam as $item)
        <tr class="border-t">
            <td class="p-2">{{ $item->hari_buka }}</td>
            <td class="p-2">{{ $item->jam_buka }}</td>
            <td class="p-2">{{ $item->jam_tutup }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center p-4">Belum ada data jam operasional.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
