@extends('layouts.pelanggan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Hero Heading -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                Temukan Mitra Laundry di Sekitar Anda
            </h1>
            <p class="mt-4 text-lg text-gray-600">
                Pilih mitra laundry terbaik di kecamatan Anda untuk layanan cepat dan terpercaya.
            </p>
        </div>

        <!-- Form Pilih Kecamatan -->
        <div class="mb-8">
            <form action="{{ route('pelanggan.mitra.index') }}" method="GET" class="flex justify-center">
                <div class="relative w-full max-w-md">
                    <select name="kecamatan" class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kecamatan</option>
                        @foreach ($kecamatanList as $kecamatan)
                            <option value="{{ $kecamatan }}" {{ request('kecamatan') == $kecamatan ? 'selected' : '' }}>
                                {{ $kecamatan }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-2 bg-blue-600 text-white px-4 py-1 rounded-lg hover:bg-blue-700">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Peringatan jika kecamatan tidak tersedia -->
        @if($noKecamatan)
            <div class="mb-8 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg">
                <p class="font-medium">Kecamatan Anda tidak terdeteksi atau tidak ada mitra di kecamatan tersebut.</p>
                <p>Menampilkan semua mitra laundry yang tersedia. Silakan perbarui alamat Anda atau pilih kecamatan di atas.</p>
            </div>
        @endif

        <!-- Grid Mitra -->
        @if ($mitras->isEmpty())
            <div class="text-center py-12">
                <p class="text-lg text-gray-500">Belum ada mitra laundry yang tersedia.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($mitras as $mitra)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <!-- Gambar Toko -->
                        <div class="relative">
                            @if($mitra->foto_toko)
                                <img src="{{ asset('images/' . $mitra->foto_toko) }}"
                                     alt="{{ $mitra->nama_toko }}"
                                     class="w-full h-48 object-cover rounded-t-2xl">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-t-2xl flex items-center justify-center text-gray-400">
                                    Tidak ada foto
                                </div>
                            @endif
                            <!-- Kecamatan -->
                            <span class="absolute top-2 right-2 bg-blue-600 text-white text-xs font-semibold px-2 py-1 rounded-full">
                                {{ $mitra->kecamatan }}
                            </span>
                        </div>

                        <!-- Informasi Mitra -->
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $mitra->nama_toko }}</h2>
                            <p class="text-sm text-gray-600 mb-1"><strong>Kecamatan:</strong> {{ $mitra->kecamatan }}</p>
                            <p class="text-sm text-gray-600 mb-1"><strong>Alamat:</strong> {{ $mitra->alamat_lengkap }}</p>
                            <p class="text-sm text-gray-600 mb-3"><strong>Telepon:</strong> {{ $mitra->no_telepon }}</p>

                            <!-- Status -->
                            <p class="mb-4">
                                <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                    {{ ucfirst($mitra->status_approve) }}
                                </span>
                            </p>

                            <!-- Tombol Lihat Detail -->
                            <a href="{{ route('pelanggan.mitra.show', $mitra->id) }}"
                               class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition-all duration-200">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection