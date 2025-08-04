@extends('layouts.employee')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">👤 Detail Walk-in Customer</h1>

    <div class="space-y-2">
        <p><strong>Nama:</strong> {{ $walkinCustomer->nama }}</p>
        <p><strong>No. Telepon:</strong> {{ $walkinCustomer->no_tlp }}</p>
        <p><strong>Alamat:</strong> {{ $walkinCustomer->alamat }}</p>
    </div>

    <div class="mt-4">
        <a href="{{ route('employee.walkin_customer.edit', $walkinCustomer) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            ✏️ Edit
        </a>
    </div>
</div>
@endsection
