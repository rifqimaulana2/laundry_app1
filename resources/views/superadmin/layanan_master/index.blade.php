@extends('layouts.superadmin')

@section('title', 'Manajemen Layanan Master')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manajemen Layanan Master</h1>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <div class="flex space-x-4">
                <button id="tab-jenis" class="px-4 py-2 font-semibold text-sm rounded-lg focus:outline-none transition-colors duration-200 bg-blue-600 text-white">Jenis Layanan</button>
                <button id="tab-kiloan" class="px-4 py-2 font-semibold text-sm rounded-lg focus:outline-none transition-colors duration-200 text-gray-700 hover:bg-gray-100">Layanan Kiloan</button>
                <button id="tab-satuan" class="px-4 py-2 font-semibold text-sm rounded-lg focus:outline-none transition-colors duration-200 text-gray-700 hover:bg-gray-100">Layanan Satuan</button>
            </div>
        </div>

        <div id="content-jenis" class="tab-content">
            <div class="flex justify-end mb-4">
                <a href="{{ route('superadmin.layanan-master.jenis.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                    <i data-lucide="plus" class="w-5 h-5"></i> Tambah Jenis Layanan
                </a>
            </div>
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-700">Nama Layanan</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenisLayanans as $jenisLayanan)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-4 text-sm text-gray-800">{{ $jenisLayanan->nama_layanan }}</td>
                            <td class="p-4 flex gap-2">
                                <a href="{{ route('superadmin.layanan-master.jenis.edit', $jenisLayanan) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 flex items-center gap-2">
                                    <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                </a>
                                <form action="{{ route('superadmin.layanan-master.jenis.destroy', $jenisLayanan) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center gap-2" onclick="return confirm('Hapus jenis layanan?')">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="p-4 text-center text-sm text-gray-500">Tidak ada jenis layanan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="content-kiloan" class="tab-content hidden">
            <div class="flex justify-end mb-4">
                <a href="{{ route('superadmin.layanan-master.kiloan.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                    <i data-lucide="plus" class="w-5 h-5"></i> Tambah Layanan Kiloan
                </a>
            </div>
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-700">Nama Paket</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Jenis Layanan</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($layananKiloans as $layanan)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-4 text-sm text-gray-800">{{ $layanan->nama_paket }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $layanan->jenisLayanan->nama_layanan }}</td>
                            <td class="p-4 flex gap-2">
                                <a href="{{ route('superadmin.layanan-master.kiloan.edit', $layanan) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 flex items-center gap-2">
                                    <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                </a>
                                <form action="{{ route('superadmin.layanan-master.kiloan.destroy', $layanan) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center gap-2" onclick="return confirm('Hapus layanan kiloan?')">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-sm text-gray-500">Tidak ada layanan kiloan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="content-satuan" class="tab-content hidden">
            <div class="flex justify-end mb-4">
                <a href="{{ route('superadmin.layanan-master.satuan.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                    <i data-lucide="plus" class="w-5 h-5"></i> Tambah Layanan Satuan
                </a>
            </div>
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-700">Nama Layanan</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Jenis Layanan</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($layananSatuans as $layanan)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-4 text-sm text-gray-800">{{ $layanan->nama_layanan }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $layanan->jenisLayanan->nama_layanan }}</td>
                            <td class="p-4 flex gap-2">
                                <a href="{{ route('superadmin.layanan-master.satuan.edit', $layanan) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 flex items-center gap-2">
                                    <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                </a>
                                <form action="{{ route('superadmin.layanan-master.satuan.destroy', $layanan) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center gap-2" onclick="return confirm('Hapus layanan satuan?')">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-sm text-gray-500">Tidak ada layanan satuan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('[id^="tab-"]');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and add to the clicked one
                tabs.forEach(t => t.classList.remove('bg-blue-600', 'text-white'));
                tabs.forEach(t => t.classList.add('text-gray-700', 'hover:bg-gray-100'));
                tab.classList.remove('text-gray-700', 'hover:bg-gray-100');
                tab.classList.add('bg-blue-600', 'text-white');

                // Hide all contents and show the one corresponding to the clicked tab
                contents.forEach(content => content.classList.add('hidden'));
                const targetContentId = tab.id.replace('tab-', 'content-');
                document.getElementById(targetContentId).classList.remove('hidden');
            });
        });
    });
</script>
@endsection