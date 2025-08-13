@extends('layouts.superadmin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">Daftar Mitra Laundry</h1>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('superadmin.mitras.index') }}" class="mb-6 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama toko, pemilik, atau kecamatan..."
            class="flex-1 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('superadmin.mitras.index') }}"
                class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">
                Reset
            </a>
        @endif
    </form>

    {{-- Tabel mitra --}}
    <div class="bg-white rounded-3xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-semibold text-gray-700">Foto Toko</th>
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
                    @forelse ($mitras as $mitra)
                        <tr class="border-b hover:bg-gray-50">
                            {{-- Foto Toko --}}
                            <td class="py-3 px-4">
                                @if($mitra->foto_toko)
                                    <img src="{{ asset('storage/' . $mitra->foto_toko) }}" 
                                         alt="Foto {{ $mitra->nama_toko }}" 
                                         class="w-16 h-16 object-cover rounded-lg border">
                                @else
                                    <span class="text-gray-400 text-sm">Tidak ada</span>
                                @endif
                            </td>

                            {{-- Nama Toko --}}
                            <td class="py-3 px-4 font-medium text-gray-800">{{ $mitra->nama_toko }}</td>

                            {{-- Pemilik --}}
                            <td class="py-3 px-4">{{ $mitra->user->name }}</td>

                            {{-- Kecamatan --}}
                            <td class="py-3 px-4">{{ $mitra->kecamatan }}</td>

                            {{-- Alamat --}}
                            <td class="py-3 px-4">{{ $mitra->alamat_lengkap }}</td>

                            {{-- No Telepon --}}
                            <td class="py-3 px-4">{{ $mitra->no_telepon }}</td>

                            {{-- Status --}}
                            <td class="py-3 px-4">
                                @if($mitra->status_approve === 'pending')
                                    <span class="px-3 py-1 rounded-lg bg-yellow-100 text-yellow-800 text-xs font-semibold">Pending</span>
                                @elseif($mitra->status_approve === 'disetujui')
                                    <span class="px-3 py-1 rounded-lg bg-green-100 text-green-800 text-xs font-semibold">Disetujui</span>
                                @else
                                    <span class="px-3 py-1 rounded-lg bg-red-100 text-red-800 text-xs font-semibold">Ditolak</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="py-3 px-4 flex gap-2 flex-wrap">
                                {{-- Approve --}}
                                @if($mitra->status_approve === 'pending' || $mitra->status_approve === 'ditolak')
                                    <form action="{{ route('superadmin.mitras.approve', $mitra->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="px-3 py-1 bg-green-500 text-white rounded-lg text-xs font-semibold hover:bg-green-600 transition">
                                            Approve
                                        </button>
                                    </form>
                                @endif

                                {{-- Reject --}}
                                @if($mitra->status_approve === 'pending' || $mitra->status_approve === 'disetujui')
                                    <form action="{{ route('superadmin.mitras.reject', $mitra->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="px-3 py-1 bg-yellow-500 text-white rounded-lg text-xs font-semibold hover:bg-yellow-600 transition">
                                            Reject
                                        </button>
                                    </form>
                                @endif

                                {{-- Hapus --}}
                                <form action="{{ route('superadmin.mitras.destroy', $mitra) }}" method="POST" 
                                      onsubmit="return confirm('Hapus mitra?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="px-3 py-1 bg-red-500 text-white rounded-lg text-xs font-semibold hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">
                                Belum ada data mitra
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $mitras->links() }}
        </div>
    </div>
</div>
@endsection
