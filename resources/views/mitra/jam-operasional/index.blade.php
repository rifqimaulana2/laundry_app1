@extends('layouts.mitra')

@section('title', 'Jam Operasional')

@section('content')
<h2 class="text-xl font-semibold mb-4">Jam Operasional</h2>

<table class="w-full text-sm bg-white rounded shadow">
    <thead class="bg-blue-800 text-white">
        <tr>
            <th class="p-3">Hari</th>
            <th class="p-3">Buka</th>
            <th class="p-3">Tutup</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jam as $j)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ ucfirst($j->hari) }}</td>
                <td class="p-3">{{ $j->jam_buka }}</td>
                <td class="p-3">{{ $j->jam_tutup }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
