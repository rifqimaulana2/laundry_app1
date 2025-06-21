@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gradient-to-br from-teal-50 to-blue-100 min-h-screen">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-4 animate-fade-in">Riwayat Transaksi</h1>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto">Lihat semua pesanan Anda di sini.</p>
    </div>

    <section class="bg-white shadow-xl rounded-2xl p-8">
        @if ($transactions->isEmpty())
            <p class="text-center text-gray-700 text-lg py-6">Belum ada riwayat transaksi.</p>
        @else
            <div class="space-y-6">
                @foreach ($transactions as $transaction)
                    <div class="bg-teal-50 p-6 rounded-lg border-l-4 border-teal-600 hover:shadow-lg transition duration-300">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-semibold text-gray-800">
                                Pesanan #{{ $transaction->id ?? 'N/A' }}
                            </h3>
                            <span class="text-sm text-teal-600">
                                {{ $transaction->created_at ? $transaction->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}
                            </span>
                        </div>

                        <p class="text-gray-700">Mitra: {{ $transaction->toko->nama_toko ?? 'Tidak tersedia' }}</p>
                        <p class="text-gray-700">Total: Rp{{ number_format($transaction->total ?? 0) }}</p>
                        <p class="text-gray-700">Status: {{ ucfirst(str_replace('_', ' ', $transaction->status ?? 'Tidak diketahui')) }}</p>

                        @if (!empty($transaction->id))
                            <a href="{{ route('pelanggan.tracking', ['id' => $transaction->id]) }}"
                               class="mt-2 inline-block bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-600 transition">
                                Lacak Pesanan
                            </a>
                        @else
                            <span class="mt-2 inline-block text-red-600">ID pesanan tidak valid</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
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
