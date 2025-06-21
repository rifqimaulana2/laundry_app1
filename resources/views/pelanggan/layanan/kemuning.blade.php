@extends('layouts.app')

@section('title', 'Layanan - Laundry Kemuning')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gradient-to-br from-teal-50 to-blue-100 min-h-screen">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-4 animate-fade-in">Layanan Laundry Kemuning</h1>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto">Nikmati layanan laundry berkualitas dengan proses mudah dan transparan. Pilih layanan yang Anda butuhkan!</p>
    </div>

    <!-- Profil Mitra -->
    <section class="bg-white shadow-xl rounded-2xl p-8 mb-12">
        <h2 class="text-2xl font-semibold text-blue-800 mb-4">Profil Mitra</h2>
        <div class="flex flex-col md:flex-row items-center gap-6">
            <img src="{{ asset('storage/mitra/kemuning.jpg') }}" alt="Kemuning Laundry" class="w-32 h-32 object-cover rounded-full border-4 border-teal-100">
            <div class="text-center md:text-left">
                <h3 class="text-xl font-bold text-gray-800">Laundry Kemuning</h3>
                <p class="text-gray-700">Alamat: Jl. Kemuning No. 123</p>
                <p class="text-gray-700">Kontak: +62 812-3456-7890</p>
                <p class="text-teal-600 font-medium mt-2">Tersedia 24/7 | Rating: ★★★★☆ (4.5/5)</p>
            </div>
        </div>
        <p class="mt-4 text-sm text-gray-600">Laundry Kemuning menawarkan layanan profesional dengan pengalaman lebih dari 5 tahun. Kami berkomitmen untuk memberikan hasil terbaik!</p>
    </section>

    <!-- Form Checkout -->
    <form action="{{ route('pelanggan.pesan', ['slug' => 'kemuning']) }}" method="POST" id="laundryForm">
        @csrf

        <!-- Layanan Kiloan -->
        <section class="bg-white shadow-xl rounded-2xl p-8 mb-12">
            <h2 class="text-2xl font-semibold text-blue-800 mb-4">Layanan Kiloan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="estimasi_kg" class="block text-sm font-medium text-gray-700">Estimasi Berat (kg)</label>
                    <input type="number" name="estimasi_kg" id="estimasi_kg" min="0" step="0.1" value="{{ old('estimasi_kg', $userProfile['estimasi_kg'] ?? 0) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 @error('estimasi_kg') border-red-500 @enderror">
                    @error('estimasi_kg')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="kiloan_type" class="block text-sm font-medium text-gray-700">Jenis Layanan</label>
                    <select name="kiloan_type" id="kiloan_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="reguler" {{ old('kiloan_type') === 'reguler' ? 'selected' : '' }}>Reguler (Rp10.000/kg, ~2 hari)</option>
                        <option value="ekspres" {{ old('kiloan_type') === 'ekspres' ? 'selected' : '' }}>Ekspres (Rp15.000/kg, ~1 hari)</option>
                    </select>
                </div>
            </div>
            <p class="text-sm text-gray-600 mt-2">*Berat real akan dikonfirmasi oleh mitra setelah penjemputan.</p>
        </section>

        <!-- Layanan Satuan -->
        <section class="bg-white shadow-xl rounded-2xl p-8 mb-12">
            <h2 class="text-2xl font-semibold text-blue-800 mb-4">Layanan Satuan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $items = [
                        ['nama' => 'Kemeja', 'harga' => 8000, 'deskripsi' => 'Cuci + Setrika', 'icon' => '👔'],
                        ['nama' => 'Celana Panjang', 'harga' => 10000, 'deskripsi' => 'Cuci + Setrika Ekstra', 'icon' => '👖'],
                        ['nama' => 'Jaket', 'harga' => 15000, 'deskripsi' => 'Cuci + Setrika Intensif', 'icon' => '🧥'],
                        ['nama' => 'Sprei', 'harga' => 12000, 'deskripsi' => 'Cuci + Lipat', 'icon' => '🛏️'],
                        ['nama' => 'Selimut', 'harga' => 20000, 'deskripsi' => 'Cuci + Pengering', 'icon' => '🛋️'],
                    ];
                @endphp
                @foreach ($items as $item)
                <div class="bg-gradient-to-br from-gray-50 to-white p-6 rounded-xl border border-gray-200">
                    <div class="flex items-center mb-4">
                        <span class="text-2xl mr-2">{{ $item['icon'] }}</span>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $item['nama'] }}</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">{{ $item['deskripsi'] }}</p>
                    <p class="text-teal-600 font-bold mb-4">Rp{{ number_format($item['harga']) }}</p>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="minus-btn w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300" data-target="item-{{ $loop->index }}">-</button>
                        <input type="number" id="item-{{ $loop->index }}" name="barang[{{ $item['nama'] }}]" min="0" value="{{ old("barang.$item[nama]", $userProfile['barang'][$item['nama']] ?? 0) }}"
                            class="w-16 text-center border-2 rounded-md @error("barang.$item[nama]") border-red-500 @enderror">
                        <button type="button" class="plus-btn w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300" data-target="item-{{ $loop->index }}">+</button>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Informasi Pelanggan -->
        <section class="bg-white shadow-xl rounded-2xl p-8">
            <h2 class="text-2xl font-semibold text-blue-800 mb-6">Informasi Pelanggan</h2>

            @if (session('success'))
                <div class="bg-teal-100 border border-teal-400 text-teal-700 px-4 py-3 rounded mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', auth()->user()->nama ?? '') }}" readonly
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon', auth()->user()->telepon ?? '') }}" readonly
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="mt-6">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Penjemputan</label>
                <textarea name="alamat" id="alamat" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('alamat', auth()->user()->alamat ?? '') }}</textarea>
            </div>

            <div class="mt-6">
                <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="transfer" {{ old('metode_pembayaran') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="cod" {{ old('metode_pembayaran') === 'cod' ? 'selected' : '' }}>COD</option>
                </select>
            </div>

            <div class="mt-8 flex justify-between">
                <button type="submit" name="action" value="single" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold">
                    Checkout Satu Layanan
                </button>
                <button type="submit" name="action" value="combined" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                    Checkout Kiloan + Satuan
                </button>
            </div>
        </section>
    </form>
</div>

<!-- Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Counter untuk tombol + dan -
        document.querySelectorAll('.plus-btn').forEach(button => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.target);
                input.value = parseInt(input.value || 0) + 1;
            });
        });

        document.querySelectorAll('.minus-btn').forEach(button => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.target);
                if (parseInt(input.value) > 0) input.value = parseInt(input.value) - 1;
            });
        });

        // Validasi sebelum submit
        const form = document.getElementById('laundryForm');
        form.addEventListener('submit', function (e) {
            const kiloan = parseFloat(document.getElementById('estimasi_kg').value || 0);
            const satuanInputs = document.querySelectorAll('input[name^="barang["]');
            let satuanJumlah = 0;
            satuanInputs.forEach(input => satuanJumlah += parseInt(input.value || 0));

            if (kiloan <= 0 && satuanJumlah <= 0) {
                e.preventDefault();
                alert('Silakan pilih minimal satu layanan (kiloan atau satuan) sebelum checkout.');
            }
        });
    });
</script>

<style>
    .animate-fade-in { animation: fadeIn 0.5s ease-in; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
@endsection
