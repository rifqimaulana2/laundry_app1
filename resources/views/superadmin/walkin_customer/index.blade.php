<!-- resources/views/superadmin/walkin_customer/index.blade.php -->
@extends('layouts.superadmin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">Daftar Pelanggan Walk-in</h1>
        <div class="bg-white rounded-3xl shadow-lg p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 font-semibold text-gray-700">Nama</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">No Telepon</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Alamat</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Mitra</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($walkinCustomers as $customer)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $customer->nama }}</td>
                            <td class="py-3 px-4">{{ $customer->no_tlp }}</td>
                            <td class="py-3 px-4">{{ $customer->alamat }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-lg bg-green-100 text-green-800 text-xs font-semibold">{{ $customer->mitra->nama_toko }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('superadmin.walkin-customers.show', $customer) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs font-semibold hover:bg-blue-600 transition">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection