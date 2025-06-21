@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-blue-700 mb-1">LaundryKuy</h2>
    <p class="text-sm text-gray-600 mb-5">Bersih, Wangi, Tepat Waktu</p>

    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
        <p class="font-semibold text-blue-800">Data Pelanggan</p>
        <p class="text-sm text-blue-700">Silakan lengkapi data diri Anda untuk layanan LaundryKuy</p>
    </div>

    <form method="POST" action="{{ route('pelanggan.simpan-data-diri') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="w-full border rounded p-2 mt-1" placeholder="Masukkan nama lengkap" value="{{ old('nama_lengkap', $data->nama_lengkap ?? '') }}">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="text" name="no_telepon" class="w-full border rounded p-2 mt-1" placeholder="Contoh: 08123456789" value="{{ old('no_telepon', $data->no_telepon ?? '') }}">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
            <textarea name="alamat" class="w-full border rounded p-2 mt-1" placeholder="Masukkan alamat lengkap">{{ old('alamat', $data->alamat ?? '') }}</textarea>
        </div>

        <div class="flex gap-4 mb-4">
            <div class="w-1/2">
                <label class="block text-sm font-medium text-gray-700">Latitude</label>
                <input type="text" id="latitude" name="latitude" class="w-full border rounded p-2 mt-1 bg-gray-100" readonly value="{{ old('latitude', $data->latitude ?? '') }}">
            </div>
            <div class="w-1/2">
                <label class="block text-sm font-medium text-gray-700">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="w-full border rounded p-2 mt-1 bg-gray-100" readonly value="{{ old('longitude', $data->longitude ?? '') }}">
            </div>
        </div>

        <div class="text-center mb-4">
            <button type="button" onclick="getLocation()" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                Dapatkan Lokasi Saat Ini
            </button>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
        Simpan
    </button>

    </form>
</div>

<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
        }, function(error) {
            alert('Gagal mendapatkan lokasi. Mohon izinkan akses lokasi.');
        });
    } else {
        alert("Geolocation tidak didukung oleh browser Anda.");
    }
}
</script>
@endsection
