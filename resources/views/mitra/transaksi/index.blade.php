@extends('layouts.mitra')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
    {{-- Header + Filter --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">💳 Riwayat Transaksi</h1>
            <p class="text-sm text-gray-500">Semua transaksi DP dan Pelunasan yang tercatat oleh mitra.</p>
        </div>

        {{-- Simple client-side filter (opsional) --}}
        <div class="flex items-center gap-3">
            <input id="searchInput" type="text" placeholder="Cari ID Pesanan / Nama Pelanggan..."
                   class="w-64 px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <select id="filterJenis" class="px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Jenis</option>
                <option value="dp">DP</option>
                <option value="pelunasan">Pelunasan</option>
            </select>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @php
            $totalDp = $transaksi->where('jenis_transaksi','dp')->sum('nominal');
            $totalPelunasan = $transaksi->where('jenis_transaksi','pelunasan')->sum('nominal');
            $total = $transaksi->sum('nominal');
        @endphp
        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <div class="text-sm text-gray-500">Total DP</div>
            <div class="text-2xl font-semibold mt-1">Rp {{ number_format($totalDp, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <div class="text-sm text-gray-500">Total Pelunasan</div>
            <div class="text-2xl font-semibold mt-1">Rp {{ number_format($totalPelunasan, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <div class="text-sm text-gray-500">Total Semua Transaksi</div>
            <div class="text-2xl font-semibold mt-1">Rp {{ number_format($total, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Transaksi</th>
                        <th class="px-4 py-3 text-left">Pesanan</th>
                        <th class="px-4 py-3 text-left">Pelanggan</th>
                        <th class="px-4 py-3 text-left">Nominal</th>
                        <th class="px-4 py-3 text-left">Metode</th>
                        <th class="px-4 py-3 text-left">Waktu</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="divide-y divide-gray-100">
                    @forelse ($transaksi as $t)
                        @php
                            $isDp = strtolower($t->jenis_transaksi) === 'dp';
                            $badgeClass = $isDp
                                ? 'bg-amber-100 text-amber-800 border-amber-200'
                                : 'bg-emerald-100 text-emerald-800 border-emerald-200';

                            $pelangganNama = $t->pesanan?->user?->name
                                ?? $t->pesanan?->walkinCustomer?->name
                                ?? '—';
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors transaksi-row"
                            data-jenis="{{ strtolower($t->jenis_transaksi) }}"
                            data-search="{{ strtolower($t->pesanan?->id.' '.$pelangganNama) }}">
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-2 text-xs font-medium px-2.5 py-1 rounded-full border {{ $badgeClass }}">
                                    {{ strtoupper($t->jenis_transaksi) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-800">#{{ $t->pesanan?->id ?? '—' }}</div>
                                <div class="text-xs text-gray-500">{{ $t->pesanan?->jenis_pesanan ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800">{{ $pelangganNama }}</div>
                                @if($t->pesanan?->user?->pelangganProfile?->no_telepon)
                                    <div class="text-xs text-gray-500">{{ $t->pesanan->user->pelangganProfile->no_telepon }}</div>
                                @elseif($t->pesanan?->walkinCustomer?->no_telepon)
                                    <div class="text-xs text-gray-500">{{ $t->pesanan->walkinCustomer->no_telepon }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-semibold">
                                Rp {{ number_format($t->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-gray-700">{{ ucfirst($t->metode_bayar ?? '-') }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-800">
                                    {{ \Carbon\Carbon::parse($t->waktu)->format('d M Y H:i') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($t->waktu)->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('mitra.riwayat.show', $t->id) }}"
                                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Note --}}
    <p class="text-xs text-gray-500">Tip: gunakan kolom pencarian dan filter jenis untuk mempercepat pencarian transaksi.</p>
</div>

{{-- Client-side filter --}}
<script>
    const q = document.getElementById('searchInput');
    const f = document.getElementById('filterJenis');
    const rows = document.querySelectorAll('.transaksi-row');

    function applyFilter() {
        const txt = (q.value || '').toLowerCase().trim();
        const jenis = (f.value || '').toLowerCase().trim();

        rows.forEach(r => {
            const matchesText = r.dataset.search.includes(txt);
            const matchesJenis = !jenis || r.dataset.jenis === jenis;
            r.style.display = (matchesText && matchesJenis) ? '' : 'none';
        });
    }

    q.addEventListener('input', applyFilter);
    f.addEventListener('change', applyFilter);
</script>
@endsection
