@extends('layouts.superadmin')

@section('title', 'Status Master')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Daftar Status</h1>
        <a href="{{ route('superadmin.status-master.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Tambah</a>
    </div>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">#</th>
                <th class="p-3">Nama Status</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
            <tr class="border-t">
                <td class="p-3">{{ $loop->iteration }}</td>
                <td class="p-3">{{ $status->nama_status }}</td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('superadmin.status-master.edit', $status) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('superadmin.status-master.destroy', $status) }}" method="POST" onsubmit="return confirm('Hapus status ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
