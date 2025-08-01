<!-- resources/views/superadmin/mitras/index.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">Daftar Mitra Laundry</h1>
        <a href="{{ route('superadmin.mitras.create') }}" class="inline-block mb-6 px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 font-semibold transition">Tambah Mitra</a>
        <div class="bg-white rounded-3xl shadow-lg p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 font-semibold text-gray-700">Nama Toko</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Pemilik</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Kecamatan</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Alamat</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">No Telepon</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Status</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mitras as $mitra)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $mitra->nama_toko }}</td>
                            <td class="py-3 px-4">{{ $mitra->user->name }}</td>
                            <td class="py-3 px-4">{{ $mitra->kecamatan }}</td>
                            <td class="py-3 px-4">{{ $mitra->alamat_lengkap }}</td>
                            <td class="py-3 px-4">{{ $mitra->no_telepon }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-lg bg-yellow-100 text-yellow-800 text-xs font-semibold">{{ $mitra->status_approve }}</span>
                            </td>
                            <td class="py-3 px-4 flex gap-2">
                                <a href="{{ route('superadmin.mitras.edit', $mitra) }}" class="px-3 py-1 bg-yellow-400 text-blue-900 rounded-lg text-xs font-semibold hover:bg-yellow-500 transition">Edit</a>
                                <form action="{{ route('superadmin.mitras.destroy', $mitra) }}" method="POST" onsubmit="return confirm('Hapus mitra?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg text-xs font-semibold hover:bg-red-600 transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection