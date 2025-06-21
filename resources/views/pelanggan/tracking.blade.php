```blade
@extends('layouts.app')

@section('title', 'Pelacakan Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gradient-to-br from-teal-50 to-blue-100 min-h-screen">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-4 animate-fade-in">Pelacakan Pesanan</h1>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto">Pantau status pesanan Anda secara real-time.</p>
    </div>

    <section class="bg-white shadow-xl rounded-2xl p-8">
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-blue-800 mb-4">Pesanan #{{ $mitra->id ?? 'N/A' }}</h2>
            <p class="text-gray-700 mb-4">Mitra: {{ $mitra->toko->nama ?? 'Tidak tersedia' }}</p>
            <div class="space-y-6">
                <div class="flex items-center justify-center">
                    <div class="flex-1 h-1 bg-gray-200 rounded">
                        <div class="h-1 bg-teal-500 rounded" style="width: {{ $progress ?? 0 }}%"></div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
                    @php
                        $statuses = ['picked_up', 'in_progress', 'completed', 'delivered'];
                        $labels = ['Dijemput', 'Diproses', 'Selesai', 'Diantar'];
                    @endphp
                    @foreach ($statuses as $index => $status)
                        <div>
                            <div class="w-10 h-10 mx-auto bg-teal-100 rounded-full flex items-center justify-center text-teal-600 font-semibold">{{ $index + 1 }}</div>
                            <p class="text-gray-700 mt-2">{{ $labels[$index] }}</p>
                            <p class="text-xs text-gray-500">
                                @if ($mitra->status === $status && $mitra->updated_at)
                                    {{ $mitra->updated_at->format('H:i, d M Y') }}
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            <p class="mt-6 text-gray-700">
                Status Saat Ini:
                <span class="font-semibold text-teal-600">{{ ucfirst(str_replace('_', ' ', $mitra->status ?? 'Tidak diketahui')) }}</span>
            </p>
        </div>
    </section>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endsection
```