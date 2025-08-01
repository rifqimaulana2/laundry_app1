@extends('layouts.mitra')

@section('content')
    <div class="max-w-3xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Daftar Layanan Satuan</h1>
                <a href="{{ route('mitra.layanan-satuan.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">Tambah Layanan Satuan</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left rounded-xl overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 text-sm font-semibold text-gray-700">Nama Layanan</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Harga per Item</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($layananSatuans as $layanan)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-4 text-sm text-gray-800">{{ $layanan->layananSatuan->nama_layanan }}</td>
                                <td class="p-4 text-sm text-gray-800">Rp {{ number_format($layanan->harga_per_item, 0, ',', '.') }}</td>
                                <td class="p-4 flex gap-2">
                                    <a href="{{ route('mitra.layanan-satuan.edit', $layanan) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-medium">Edit</a>
                                    <form action="{{ route('mitra.layanan-satuan.destroy', $layanan) }}" method="POST" onsubmit="return confirm('Hapus layanan satuan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-sm text-gray-500">Belum ada layanan satuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection