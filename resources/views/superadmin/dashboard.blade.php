@extends('layouts.admin')

@section('title', 'Dashboard Superadmin')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Dashboard Superadmin</h1>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
        <x-dashboard-box title="Total Mitra" :value="$totalMitra" />
        <x-dashboard-box title="Mitra Disetujui" :value="$mitraDisetujui" />
        <x-dashboard-box title="Belum Disetujui" :value="$mitraBelumDisetujui" />
        <x-dashboard-box title="Langganan Aktif" :value="$mitraLanggananAktif" />
        <x-dashboard-box title="Total Pelanggan" :value="$totalPelanggan" />
        <x-dashboard-box title="Total Transaksi" :value="$totalTransaksi" />
    </div>

    <!-- Grafik -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4 text-blue-800">Pertumbuhan Mitra per Bulan</h2>
        <canvas id="mitraChart" class="w-full h-64"></canvas>
    </div>

    <!-- Tabel Mitra -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4 text-blue-800">Daftar Mitra</h2>
        <table class="w-full table-auto text-sm">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Nama Toko</th>
                    <th class="px-4 py-2 text-left">Alamat</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Langganan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mitras as $mitra)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $mitra->nama_toko }}</td>
                    <td class="px-4 py-2">{{ $mitra->alamat }}</td>
                    <td class="px-4 py-2">
                        {{ $mitra->status_approve ? 'Disetujui' : 'Menunggu' }}
                    </td>
                    <td class="px-4 py-2">
                        {{ optional($mitra->langgananMitra)->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('mitraChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($mitraLabels) !!},
            datasets: [{
                label: 'Mitra Baru',
                data: {!! json_encode($mitraData) !!},
                backgroundColor: 'rgba(59,130,246,0.7)',
                borderColor: 'rgba(59,130,246,1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
