@extends('layouts.pelanggan')

@section('content')
<div class="min-h-screen bg-gradient-to-tr from-white via-blue-50 to-blue-100 py-12">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">

        {{-- Hero Heading --}}
        <div class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-gray-800 leading-tight">Temukan Mitra Laundry Terbaik</h1>
            <p class="mt-4 text-lg text-gray-600">Cepat, bersih, dan terpercaya – layanan laundry di sekitar Anda.</p>
        </div>

        @if ($mitras->isEmpty())
            <p class="text-center text-gray-500">Belum ada mitra yang tersedia.</p>
        @else
            {{-- Grid Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($mitras as $mitra)
                    <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        {{-- Image --}}
                        @if($mitra->foto_toko)
                            <img src="{{ asset('images/' . $mitra->foto_toko) }}"
                                 alt="{{ $mitra->nama_toko }}"
                                 class="w-full h-48 object-cover rounded-t-3xl">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-t-3xl flex items-center justify-center text-gray-400">
                                Tidak ada foto
                            </div>
                        @endif

                        {{-- Info --}}
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-gray-800">{{ $mitra->nama_toko }}</h2>
                            <p class="text-sm text-gray-600 mt-1"><strong>Kecamatan:</strong> {{ $mitra->kecamatan }}</p>
                            <p class="text-sm text-gray-600"><strong>Alamat:</strong> {{ $mitra->alamat_lengkap }}</p>
                            <p class="text-sm text-gray-600"><strong>Telepon:</strong> {{ $mitra->no_telepon }}</p>

                            <p class="mt-2">
                                <strong>Status:</strong>
                                <span class="inline-block px-2 py-1 text-xs font-bold rounded-full 
                                    {{ $mitra->status_approve === 'disetujui' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($mitra->status_approve) }}
                                </span>
                            </p>

                            {{-- Button --}}
                            <div class="mt-4">
                                <a href="{{ route('pelanggan.mitra.show', $mitra->id) }}"
                                   class="inline-block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-xl transition-all duration-200">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
