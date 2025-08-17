@extends('layouts.mitra')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <h1 class="text-3xl font-bold text-emerald-600 mb-6 flex items-center gap-2">
            <i data-lucide="edit-3" class="w-7 h-7"></i> Edit Profil Mitra
        </h1>

        <form action="{{ route('mitra.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Toko --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Toko</label>
                <input type="text" name="nama_toko" value="{{ old('nama_toko', $mitra->nama_toko) }}" 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 transition"
                    required>
                @error('nama_toko')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kecamatan --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan', $mitra->kecamatan) }}" 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 transition"
                    required>
                @error('kecamatan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat Lengkap --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                <textarea name="alamat_lengkap" rows="3"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 transition"
                    required>{{ old('alamat_lengkap', $mitra->alamat_lengkap) }}</textarea>
                @error('alamat_lengkap')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Koordinat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Longitude</label>
                    <input type="text" name="longitude" value="{{ old('longitude', $mitra->longitude) }}" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 transition"
                        required>
                    @error('longitude')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Latitude</label>
                    <input type="text" name="latitude" value="{{ old('latitude', $mitra->latitude) }}" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 transition"
                        required>
                    @error('latitude')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- No Telepon --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">No Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', $mitra->no_telepon) }}" 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 transition"
                    required>
                @error('no_telepon')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Layanan Jemput & Antar --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Layanan Jemput</label>
                    <select name="layanan_jemput" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 transition">
                        <option value="1" {{ old('layanan_jemput', $mitra->layanan_jemput) ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !old('layanan_jemput', $mitra->layanan_jemput) ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Layanan Antar</label>
                    <select name="layanan_antar" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 transition">
                        <option value="1" {{ old('layanan_antar', $mitra->layanan_antar) ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !old('layanan_antar', $mitra->layanan_antar) ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            {{-- Foto Toko --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Toko</label>
                <input type="file" name="foto_toko" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 transition">
                @if ($mitra->foto_toko)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $mitra->foto_toko) }}" class="rounded-xl shadow-md border border-gray-200 w-40">
                    </div>
                @endif
            </div>

            {{-- Foto Profil --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Profil</label>
                <input type="file" name="foto_profile" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 transition">
                @if ($mitra->foto_profile)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $mitra->foto_profile) }}" class="rounded-full shadow-md border border-gray-200 w-32 h-32 object-cover">
                    </div>
                @endif
            </div>

            {{-- Tombol Simpan --}}
            <div>
                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-lg font-semibold shadow-md hover:opacity-90 transition">
                    <i data-lucide="save" class="inline-block w-5 h-5 mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection
