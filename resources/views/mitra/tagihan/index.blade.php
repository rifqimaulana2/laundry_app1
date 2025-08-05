@extends('layouts.mitra')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <div class="bg-white rounded-3xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Tagihan</h1>
        <div class="mb-6 flex gap-2">
            <select id="filterStatus" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500">
                <option value="">Semua Status</option>
                <option value="belum lunas">Belum Lunas</option>
                <option value="dp_terbayar">DP Terbayar</option>
                <option value="lunas">Lunas</option>
            </select>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left rounded-xl overflow-hidden" id="tagihanTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-700">ID Tagihan</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Pesanan</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Pelanggan</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Total Tagihan</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Sisa Tagihan</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Metode</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Jatuh Tempo</th>
                        <th class="p-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tagihanTableBody">
                    @forelse ($tagihans as $tagihan)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-4 text-sm text-gray-800">{{ $tagihan->id }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $tagihan->pesanan->id }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $tagihan->pesanan->user ? $tagihan->pesanan->user->name : $tagihan->pesanan->walkinCustomer->nama }}</td>
                            <td class="p-4 text-sm text-gray-800">Rp {{ number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') }}</td>
                            <td class="p-4 text-sm text-gray-800">Rp {{ number_format($tagihan->sisa_tagihan ?? 0, 0, ',', '.') }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $tagihan->metode_bayar }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $tagihan->status_pembayaran }}</td>
                            <td class="p-4 text-sm text-gray-800">{{ $tagihan->jatuh_tempo_pelunasan ?? '-' }}</td>
                            <td class="p-4">
                                <a href="{{ route('mitra.tagihan.show', $tagihan) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-medium">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-4 text-center text-sm text-gray-500">Belum ada tagihan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const filterStatus = document.getElementById('filterStatus');
    const tagihanTableBody = document.getElementById('tagihanTableBody');
    filterStatus.addEventListener('change', function () {
        fetch(`?status=${encodeURIComponent(this.value)}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newBody = doc.getElementById('tagihanTableBody');
                if (newBody) tagihanTableBody.innerHTML = newBody.innerHTML;
            })
            .catch(err => console.error('Error fetching data:', err));
    });
</script>
@endsection