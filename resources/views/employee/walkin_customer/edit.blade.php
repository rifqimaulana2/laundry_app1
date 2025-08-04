@extends('layouts.employee')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">✏️ Edit Walk-in Customer</h1>

    <form action="{{ route('employee.walkin_customer.update', $walkinCustomer) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $walkinCustomer->nama) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label for="no_tlp" class="block text-sm font-medium">No. Telepon</label>
            <input type="text" name="no_tlp" id="no_tlp" value="{{ old('no_tlp', $walkinCustomer->no_tlp) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label for="alamat" class="block text-sm font-medium">Alamat</label>
            <textarea name="alamat" id="alamat" class="w-full border rounded p-2" required>{{ old('alamat', $walkinCustomer->alamat) }}</textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Perbarui</button>
    </form>
</div>
@endsection
