@extends('layouts.employee')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">🧾 Tambah Pesanan Walk-in Customer</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('employee.pesanan.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="walkin_customer_id" class="block text-sm font-medium mb-1">Pilih Pelanggan Walk-in</label>
            <select name="walkin_customer_id" id="walkin_customer_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih pelanggan lama --</option>
                @foreach($walkinCustomers as $customer)
                    <option value="{{ $customer->id }}">
                        {{ $customer->nama }} - {{ $customer->no_tlp }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500 mt-1">Jika pelanggan baru, silakan tambahkan lewat menu pelanggan.</p>
        </div>

        <div class="mb-4">
            <label for="jenis_pesanan" class="block text-sm font-medium mb-1">Jenis Pesanan</label>
            <select name="jenis_pesanan" id="jenis_pesanan" class="w-full border rounded p-2" required>
                <option value="">-- Pilih jenis layanan --</option>
                <option value="Kiloan">Kiloan</option>
                <option value="Satuan">Satuan</option>
                <option value="Kiloan + Satuan">Kiloan + Satuan</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Pesanan
        </button>
    </form>
</div>
@endsection
