@extends('layouts.app')

@section('content')
<section class="py-8 bg-gradient-to-br from-teal-50 to-white min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-teal-600 mb-4">Pelacakan Pesanan</h2>
        <p class="text-base sm:text-lg text-gray-700 mb-6 max-w-xl mx-auto">
            Lacak status pesanan Anda secara real-time dengan mudah.
        </p>

        <form action="{{ route('pelacakan') }}" method="GET" class="max-w-md mx-auto">
            <div class="flex flex-col sm:flex-row gap-3">
                <input
                    type="text"
                    name="kode"
                    required
                    minlength="5"
                    placeholder="Masukkan kode pesanan"
                    class="w-full border border-gray-300 rounded-md shadow-sm p-3 text-sm sm:text-base focus:ring-teal-400 focus:border-teal-400 bg-white"
                />
                <button
                    type="submit"
                    class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-5 rounded-lg transition-colors text-sm sm:text-base"
                >
                    Lacak
                </button>
            </div>
        </form>

        {{-- Penjelasan cara melacak --}}
        <div class="mt-8 text-left max-w-md mx-auto text-gray-600">
            <h3 class="text-lg font-semibold mb-2">Cara Melacak Pesanan:</h3>
            <ul class="list-disc pl-5 space-y-1 text-sm">
                <li>Masukkan kode pesanan yang Anda terima saat pemesanan.</li>
                <li>Klik tombol <strong>Lacak</strong>.</li>
                <li>Lihat status pesanan Anda secara real-time.</li>
            </ul>
        </div>

        {{-- Ilustrasi --}}
        <div class="mt-10">
            <img src="{{ asset('images/tracking_illustration.svg') }}" alt="Ilustrasi Pelacakan" class="w-full max-w-md mx-auto">
        </div>

        {{-- Hasil pelacakan --}}
        @if(request('kode'))
            @if($status)
                <div class="mt-6 bg-white shadow rounded-lg p-4 max-w-md mx-auto text-left border border-teal-100">
                    <h3 class="text-lg font-bold text-teal-600 mb-2">Status Pesanan: {{ $status->status }}</h3>
                    <p class="text-gray-700 text-sm">Diterima pada: {{ $status->created_at->format('d M Y H:i') }}</p>
                </div>
            @else
                <div class="mt-6 text-red-500 font-medium">Kode pesanan tidak ditemukan. Coba periksa kembali.</div>
            @endif
        @endif
    </div>
</section>
@endsection
