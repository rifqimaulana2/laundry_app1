@extends('layouts.mitra')

@section('content')
    <div class="max-w-xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Layanan Kiloan</h1>
            <form action="{{ route('mitra.layanan-kiloan.update', $layananKiloan) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Nama Paket</label>
                    <select name="layanan_kiloan_id" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                        @foreach ($layananKiloans as $layanan)
                            <option value="{{ $layanan->id }}" {{ $layananKiloan->layanan_kiloan_id == $layanan->id ? 'selected' : '' }}>{{ $layanan->nama_paket }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Harga per Kg</label>
                    <input type="number" name="harga_per_kg" value="{{ $layananKiloan->harga_per_kg }}" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Durasi Hari</label>
                    <input type="number" name="durasi_hari" value="{{ $layananKiloan->durasi_hari }}" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">Simpan</button>
            </form>
        </div>
    </div>
@endsection
