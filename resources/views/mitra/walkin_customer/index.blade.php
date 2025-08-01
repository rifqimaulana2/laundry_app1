@extends('layouts.mitra')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Pelanggan Walk-in</h1>
            <a href="{{ route('mitra.walkin-customers.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-medium mb-4 inline-block">Tambah Pelanggan Walk-in</a>
            <div class="mb-6 flex gap-2">
                <input type="text" id="searchInput" name="q" value="{{ request('q') }}" placeholder="Cari nama pelanggan..." class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-800 py-2 px-3">
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left rounded-xl overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 text-sm font-semibold text-gray-700">Nama</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">No Telepon</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Alamat</th>
                            <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="walkinTableBody">
                        @forelse ($walkinCustomers as $customer)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-4 text-sm text-gray-800">{{ $customer->nama }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $customer->no_tlp }}</td>
                                <td class="p-4 text-sm text-gray-800">{{ $customer->alamat }}</td>
                                <td class="p-4 flex gap-2">
                                    <a href="{{ route('mitra.walkin-customers.show', $customer) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-medium">Detail</a>
                                    <a href="{{ route('mitra.walkin-customers.edit', $customer) }}" class="px-3 py-1 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 font-medium">Edit</a>
                                    <form action="{{ route('mitra.walkin-customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Hapus pelanggan walk-in?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-sm text-gray-500">Belum ada pelanggan walk-in.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <script>
                const searchInput = document.getElementById('searchInput');
                const walkinTableBody = document.getElementById('walkinTableBody');
                let timeout = null;
                searchInput.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        fetch(`?q=${encodeURIComponent(searchInput.value)}`)
                            .then(res => res.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newBody = doc.getElementById('walkinTableBody');
                                if (newBody) walkinTableBody.innerHTML = newBody.innerHTML;
                            });
                    }, 300);
                });
            </script>
        </div>
    </div>
@endsection