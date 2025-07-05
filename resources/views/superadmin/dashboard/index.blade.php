@extends('layouts.admin')

@section('title', 'Dashboard Superadmin')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Superadmin</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Mitra</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalMitra }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Mitra Aktif</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $mitraLanggananAktif }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Pelanggan</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalPelanggan }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-dark mb-3">
                <div class="card-header">Total Transaksi</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalTransaksi }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="my-4">
        <h4>Pendapatan Total: <strong>Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</strong></h4>
    </div>

    <div class="my-5">
        <h5>Grafik Mitra Per Bulan</h5>
        <canvas id="mitraChart" height="100"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('mitraChart').getContext('2d');
    const mitraChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($mitraLabels) !!},
            datasets: [{
                label: 'Mitra Baru',
                data: {!! json_encode($mitraData) !!},
                fill: false,
                borderColor: 'blue',
                tension: 0.1
            }]
        }
    });
</script>
@endsection
