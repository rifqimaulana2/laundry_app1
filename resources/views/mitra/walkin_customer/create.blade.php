@extends('layouts.mitra')

@section('content')
    <div class="max-w-xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Pelanggan Walk-in</h1>
            <form action="{{ route('mitra.walkin-customers.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-1">Nama</label>
                    <input type="text" name="nama" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">No Telepon</label>
                    <input type="text" name="no_tlp" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required></textarea>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-medium">Simpan</button>
            </form>
        </div>
    </div>
@endsection