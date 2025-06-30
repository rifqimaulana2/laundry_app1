@extends('layouts.admin')

@section('title', 'Persetujuan Mitra')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Persetujuan Mitra Baru</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($mitras->isEmpty())
        <div class="text-gray-500">Tidak ada mitra yang menunggu persetujuan.</div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Usaha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kecamatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($mitras as $user)
                        <tr>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->nama_usaha ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $user->no_telepon ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $user->kecamatan ?? '-' }}</td>
                            <td class="px-6 py-4 space-x-2">
                                <form action="{{ route('superadmin.mitra.approve', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                        Setujui
                                    </button>
                                </form>

                                <form action="{{ route('superadmin.mitra.reject', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menolak mitra ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                        Tolak
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
