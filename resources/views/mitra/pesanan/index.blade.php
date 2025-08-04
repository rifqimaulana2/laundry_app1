@extends('layouts.mitra')

@section('content')
    <div class="max-w-5xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Daftar Pesanan</h1>
                <a href="{{ route('mitra.pesanan.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">Tambah Pesanan</a>
            </div>
            <div class="mb-6 flex gap-2">
                <input type="text" id="searchInput" name="q" value="{{ request('q') }}" placeholder="Cari nama pelanggan..." class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3">
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left rounded-xl overflow-hidden" id="pesananTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 text-sm font-semibold text-gray-700">ID</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Pelanggan</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Jenis Pesanan</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Tanggal Pesan</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Status</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pesananTableBody">
                        @forelse ($pesanans as $pesanan)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-4 text-sm text-gray-800">{{ $pesanan->id }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $pesanan->user ? $pesanan->user->name : $pesanan->walkinCustomer->nama }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $pesanan->jenis_pesanan }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $pesanan->tanggal_pesan }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $pesanan->tagihan->status_pembayaran ?? 'Menunggu' }}</td>
                            <td class="p-4">
                                <a href="{{ route('mitra.pesanan.show', $pesanan) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-medium">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-sm text-gray-500">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <script>
                const searchInput = document.getElementById('searchInput');
                const pesananTableBody = document.getElementById('pesananTableBody');
                let timeout = null;
                searchInput.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        fetch(`?q=${encodeURIComponent(searchInput.value)}`)
                            .then(res => res.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newBody = doc.getElementById('pesananTableBody');
                                if (newBody) pesananTableBody.innerHTML = newBody.innerHTML;
                            });
                    }, 300);
                });
            </script>
        </div>
    </div>
@endsection