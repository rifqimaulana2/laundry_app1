@extends('layouts.mitra')

@section('title', 'Form Layanan')

@section('content')
<h2 class="text-xl font-semibold mb-4">{{ isset($layanan) ? 'Edit' : 'Tambah' }} Layanan</h2>

<form action="{{ isset($layanan) ? route('mitra.layanan.update', $layanan->id) : route('mitra.layanan.store') }}" method="POST" class="space-y-4 bg-white p-4 rounded shadow">
    @csrf
    @if(isset($layanan))
        @method('PUT')
    @endif

    <div>
        <label>Nama Layanan</label>
        <input type="text" name="nama" class="w-full border p-2" value="{{ old('nama', $layanan->nama ?? '') }}">
    </div>

    <div>
        <label>Jenis</label>
        <select name="tipe" class="w-full border p-2">
            <option value="kiloan" {{ (old('tipe', $layanan->tipe ?? '') === 'kiloan') ? 'selected' : '' }}>Kiloan</option>
            <option value="satuan" {{ (old('tipe', $layanan->tipe ?? '') === 'satuan') ? 'selected' : '' }}>Satuan</option>
        </select>
    </div>

    <div>
        <label>Harga</label>
        <input type="number" name="harga" class="w-full border p-2" value="{{ old('harga', $layanan->harga ?? '') }}">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>
</form>
@endsection
