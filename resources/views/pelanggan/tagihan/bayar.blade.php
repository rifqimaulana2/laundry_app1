@extends('layouts.pelanggan')

@section('content')
<div class="p-6 max-w-xl mx-auto bg-white rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4">💳 Bayar Tagihan #{{ $tagihan->id }}</h2>

    {{-- Flash message --}}
    @foreach (['error' => 'red', 'success' => 'green'] as $msg => $color)
        @if (session($msg))
            <div class="mb-4 p-4 bg-{{ $color }}-100 text-{{ $color }}-700 rounded-md">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    <div class="space-y-2 mb-4">
        <p>Jenis Pembayaran: <strong>{{ $jenisPembayaran }}</strong></p>
        <p>Total yang harus dibayar:
            <strong>Rp {{ number_format($totalBayar, 0, ',', '.') }}</strong>
        </p>
    </div>

    {{-- Form Konfirmasi Bayar --}}
    <form method="POST" action="{{ route('pelanggan.tagihan.prosesBayar', $tagihan->id) }}">
        @csrf
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            ✅ Konfirmasi Bayar
        </button>
        <a href="{{ route('pelanggan.tagihan.show', $tagihan->id) }}"
           class="ml-2 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
            ⬅ Kembali
        </a>
    </form>
</div>
@endsection
