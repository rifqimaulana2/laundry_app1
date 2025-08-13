@extends('layouts.superadmin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">Daftar Pengguna</h1>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('superadmin.users.index') }}" class="mb-6 flex flex-col sm:flex-row gap-3 items-center">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, email, atau role..."
            class="w-full sm:w-72 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
        <button type="submit"
            class="px-5 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 font-semibold transition">
            Cari
        </button>
    </form>

    {{-- Tabel Pengguna --}}
    <div class="bg-white rounded-3xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-semibold text-gray-700">Nama</th>
                        <th class="py-3 px-4 font-semibold text-gray-700">Email</th>
                        <th class="py-3 px-4 font-semibold text-gray-700">Role</th>
                        <th class="py-3 px-4 font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-lg 
                                    @if($user->role === 'superadmin') bg-purple-100 text-purple-800
                                    @elseif($user->role === 'mitra') bg-green-100 text-green-800
                                    @elseif($user->role === 'pelanggan') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif
                                    text-xs font-semibold">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Hapus pengguna ini?')">
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
                            <td colspan="4" class="text-center py-6 text-gray-500">Tidak ada pengguna ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
