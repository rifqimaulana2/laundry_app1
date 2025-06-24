```blade
@extends('layouts.app')

@section('title', 'Konfirmasi Berat')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gradient-to-br from-teal-50 to-blue-100 min-h-screen">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-4 animate-fade-in">Konfirmasi Berat Pesanan</h1>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto">Masukkan berat real setelah penjemputan.</p>
    </div>

    <section class="bg-white shadow-xl rounded-2xl p-8">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 animate-fade-in" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($mitra->id)
            <form action="{{ route('pelanggan.konfirmasi.update', ['id' => $mitra->id]) }}" method="POST">
                @csrf
                @method('POST')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="confirmed_kg" class="block text-sm font-medium text-gray-700">Berat Real (kg)</label>
                        <input type="number" name="confirmed_kg" id="confirmed_kg" min="0" step="0.1" value="{{ old('confirmed_kg', $detail['kiloan']['estimasi_kg'] ?? 0) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 @error('confirmed_kg') border-red-500 @enderror">
                        @error('confirmed_kg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-gradient-to-r from-teal-600 to-blue-800 text-white px-6 py-3 rounded-lg hover:from-teal-700 hover:to-blue-900 transition duration-300 transform hover:scale-105 font-semibold">
                        Konfirmasi Berat
                    </button>
                </div>
            </form>
        @else
            <p class="text-center text-red-600">Pesanan tidak valid.</p>
        @endif
    </section>
</div>

<style>
    .animate-fade-in { animation: fadeIn 0.5s ease-in; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
@endsection
```