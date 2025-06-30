@extends('layouts.mitra')

@section('title', 'Dashboard Mitra')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <x-dashboard-box title="Total Pesanan" :value="$totalPesanan" />
    <x-dashboard-box title="Diproses" :value="$diproses" />
    <x-dashboard-box title="Selesai" :value="$selesai" />
    <x-dashboard-box title="Dibatalkan" :value="$dibatalkan" />
</div>

{{-- Status Langganan --}}
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <h3 class="text-xl font-semibold text-blue-800 mb-4">Status Langganan</h3>
    <p>Status: <strong>{{ $statusLangganan ?? 'Belum Berlangganan' }}</strong></p>
    <p>Berlaku Sampai: <strong>{{ $berlakuSampai ?? '-' }}</strong></p>
</div>

{{-- Grafik Layanan Populer --}}
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-xl font-semibold text-blue-800 mb-4">Grafik Layanan Paling Populer</h3>
    <canvas id="layananChart" class="w-full h-64"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('layananChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($layananLabels) !!},
            datasets: [{
                label: 'Jumlah Dipesan',
                data: {!! json_encode($layananData) !!},
                backgroundColor: 'rgba(59,130,246,0.6)',
                borderColor: 'rgba(59,130,246,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
