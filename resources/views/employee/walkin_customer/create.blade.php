@extends('layouts.employee')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">➕ Tambah Walk-in Customer</h1>

    <form action="{{ route('employee.walkin_customer.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium">Nama</label>
            <input type="text" name="nama" id="nama" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label for="no_tlp" class="block text-sm font-medium">No. Telepon</label>
            <input type="text" name="no_tlp" id="no_tlp" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label for="alamat" class="block text-sm font-medium">Alamat</label>
            <textarea name="alamat" id="alamat" class="w-full border rounded p-2" required></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </form>
</div>
@endsection
