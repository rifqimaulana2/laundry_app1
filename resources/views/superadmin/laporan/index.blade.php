@extends('layouts.superadmin')

@section('content')
<div class="bg-gray-50 min-h-screen p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Laporan Pelanggan</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Laporan --}}
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-700 text-sm uppercase tracking-wide">
                    <th class="px-4 py-3 border">ID</th>
                    <th class="px-4 py-3 border">Mitra</th>
                    <th class="px-4 py-3 border">Pelapor</th>
                    <th class="px-4 py-3 border">Deskripsi</th>
                    <th class="px-4 py-3 border">Bukti</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($laporans as $laporan)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $laporan->id }}</td>
                        <td class="px-4 py-2">{{ $laporan->mitra->nama_toko ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $laporan->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $laporan->deskripsi }}</td>
                        <td class="px-4 py-2">
                            @if($laporan->bukti)
                                <a href="{{ asset('storage/'.$laporan->bukti) }}" target="_blank"
                                   class="text-blue-500 hover:text-blue-700 underline">Lihat</a>
                            @else
                                <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <span class="px-3 py-1 rounded-full text-white text-xs font-medium
                                @if($laporan->status === 'pending') bg-yellow-500
                                @elseif($laporan->status === 'diterima') bg-green-600
                                @elseif($laporan->status === 'ditolak') bg-red-600 @endif">
                                {{ ucfirst($laporan->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('superadmin.laporan.update-status', $laporan->id) }}" method="POST" class="flex gap-2">
                                @csrf
                                <select name="status" class="border rounded px-2 py-1 text-sm">
                                    <option value="pending"  {{ $laporan->status=='pending'  ? 'selected' : '' }}>Pending</option>
                                    <option value="diterima" {{ $laporan->status=='diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="ditolak"  {{ $laporan->status=='ditolak'  ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Update</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            Belum ada laporan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
