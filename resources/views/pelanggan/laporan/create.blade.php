@extends('layouts.pelanggan')

@section('content')
<div class="bg-gray-50 min-h-screen py-12 px-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Kirim Laporan</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pelanggan.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Pilih Mitra --}}
            <div>
                <label class="block text-sm font-medium mb-1">Pilih Mitra</label>
                <select name="mitra_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Mitra --</option>
                    @foreach($mitras as $mitra)
                        <option value="{{ $mitra->id }}">{{ $mitra->nama_toko ?? $mitra->nama }}</option>
                    @endforeach
                </select>
                @error('mitra_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi Masalah</label>
                <textarea name="deskripsi" rows="4" class="w-full border rounded px-3 py-2">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Bukti --}}
            <div>
                <label class="block text-sm font-medium mb-1">Upload Bukti (opsional)</label>
                <input type="file" name="bukti" class="w-full border rounded px-3 py-2">
                @error('bukti') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
