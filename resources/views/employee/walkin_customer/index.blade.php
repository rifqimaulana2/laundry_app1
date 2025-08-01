@extends('layouts.employee')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">🧍 Daftar Walk-in Customer</h1>

    <a href="{{ route('employee.pelanggan-walkin.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">➕ Tambah Customer</a>

    <div class="overflow-x-auto">
        <table class="w-full table-auto border rounded">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">No. Telepon</th>
                    <th class="px-4 py-2">Alamat</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $customer->id }}</td>
                        <td class="border px-4 py-2">{{ $customer->nama }}</td>
                        <td class="border px-4 py-2">{{ $customer->no_tlp }}</td>
                        <td class="border px-4 py-2">{{ $customer->alamat }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('employee.pelanggan-walkin.show', $customer) }}" class="text-blue-600 hover:underline">Detail</a>
                            <a href="{{ route('employee.pelanggan-walkin.edit', $customer) }}" class="text-green-600 hover:underline ml-2">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">Belum ada data customer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
