@extends('layouts.superadmin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Daftar Employee</h2>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-100 border border-green-400 text-green-800 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search Form --}}
    <form method="GET" action="{{ route('superadmin.employees.index') }}" class="mb-6 flex flex-col sm:flex-row sm:items-center gap-3">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Cari nama, email, atau mitra..." 
            class="flex-grow border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
        >

        <button type="submit" 
            class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm font-semibold">
            Cari
        </button>

        @if(request('search'))
            <a href="{{ route('superadmin.employees.index') }}" 
                class="px-5 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition text-sm font-semibold">
                Reset
            </a>
        @endif
    </form>

    {{-- Tabel Employee --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @php
                    $ths = ['Nama Employee', 'Email', 'Mitra', 'No Telepon', 'Aksi'];
                    @endphp
                    @foreach($ths as $th)
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                        {{ $th }}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($employees as $employee)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employee->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employee->user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employee->mitra->nama_toko }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employee->no_telepon }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('superadmin.employees.destroy', $employee->id) }}" method="POST" class="inline">
                                @csrf 
                                @method('DELETE')
                                <button 
                                    onclick="return confirm('Hapus employee ini?')" 
                                    class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition text-xs font-semibold"
                                    type="submit"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400 text-sm">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $employees->links() }}
    </div>
</div>
@endsection
