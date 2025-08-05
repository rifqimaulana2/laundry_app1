```php
<!-- resources/views/mitra/tracking_status/index.blade.php -->
@extends('layouts.mitra')

@section('content')
<div class="max-w-6xl mx-auto mt-10">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Daftar Status Pelacakan</h1>
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <div class="overflow-x-auto">
            <table class="w-full text-left rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-sm font-semibold text-gray-700">ID Pesanan</th>
                        <th class="p-3 text-sm font-semibold text-gray-700">Pelanggan</th>
                        <th class="p-3 text-sm font-semibold text-gray-700">Status Terkini</th>
                        <th class="p-3 text-sm font-semibold text-gray-700">Pesan</th>
                        <th class="p-3 text-sm font-semibold text-gray-700">Waktu</th>
                        <th class="p-3 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanans as $pesanan)
                        @php
                            $latestStatus = $pesanan->trackingStatus->sortByDesc('waktu')->first();
                        @endphp
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3 text-sm text-gray-800">{{ $pesanan->id }}</td>
                            <td class="p-3 text-sm text-gray-800">
                                {{ $pesanan->user ? $pesanan->user->name : ($pesanan->walkinCustomer ? $pesanan->walkinCustomer->nama : '-') }}
                            </td>
                            <td class="p-3 text-sm text-gray-800">
                                {{ $latestStatus ? $latestStatus->statusMaster->nama_status : 'Belum ada status' }}
                            </td>
                            <td class="p-3 text-sm text-gray-800">
                                {{ $latestStatus ? $latestStatus->pesan ?? '-' : '-' }}
                            </td>
                            <td class="p-3 text-sm text-gray-800">
                                {{ $latestStatus ? \Carbon\Carbon::parse($latestStatus->waktu)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="p-3 text-sm text-gray-800">
                                <form action="{{ route('mitra.tracking_status.update', $pesanan->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status_master_id" class="border rounded-lg p-1 text-sm">
                                        <option value="" disabled selected>Pilih Status</option>
                                        @foreach (\App\Models\StatusMaster::all() as $status)
                                            <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="pesan" placeholder="Pesan (opsional)" class="border rounded-lg p-1 text-sm mt-1" maxlength="500">
                                    <button type="submit" class="bg-blue-600 text-white py-1 px-3 rounded-lg hover:bg-blue-700 mt-1">Update</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-3 text-sm text-gray-500 text-center">Tidak ada pesanan untuk ditampilkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection