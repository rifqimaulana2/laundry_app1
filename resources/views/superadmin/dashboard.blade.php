@extends('layouts.superadmin')

@section('title', 'Dashboard Superadmin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gray-50 min-h-screen">
    <h1 class="text-4xl font-bold text-gray-800 mb-10">Dashboard Superadmin</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Pengguna -->
        <a href="{{ url('/superadmin/users') }}" class="block bg-white rounded-2xl shadow p-6 hover:shadow-lg transition transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-blue-600 text-white rounded-full shadow">
                    <i data-lucide="users" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-700">Total Pengguna</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
                    <p class="text-sm text-gray-500">Pengguna terdaftar</p>
                </div>
            </div>
        </a>

        <!-- Total Mitra -->
        <a href="{{ url('/superadmin/mitras') }}" class="block bg-white rounded-2xl shadow p-6 hover:shadow-lg transition transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-green-600 text-white rounded-full shadow">
                    <i data-lucide="handshake" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-700">Total Mitra</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalMitras }}</p>
                    <p class="text-sm text-gray-500">Mitra aktif</p>
                </div>
            </div>
        </a>

        <!-- Persetujuan Mitra -->
        <a href="{{ url('/superadmin/mitras/approval') }}" class="block bg-white rounded-2xl shadow p-6 hover:shadow-lg transition transform hover:-translate-y-1">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-orange-500 text-white rounded-full shadow">
                    <i data-lucide="check-circle" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-700">Persetujuan Mitra</p>
                    <p class="text-3xl font-bold text-orange-500">{{ $totalApprovalMitra }}</p>
                    <p class="text-sm text-gray-500">Menunggu persetujuan</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Grafik -->
    <div class="bg-white rounded-2xl shadow p-6 mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Grafik Registrasi {{ now()->year }}</h2>
        <canvas id="registrasiChart" height="120"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    lucide.createIcons();

    const ctx = document.getElementById('registrasiChart').getContext('2d');
    const registrasiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: 'Pengguna',
                    data: {!! json_encode($users) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Mitra',
                    data: {!! json_encode($mitras) !!},
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Jumlah' }
                }
            }
        }
    });
</script>
@endpush
