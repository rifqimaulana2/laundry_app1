@extends('layouts.pelanggan')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded-2xl shadow-xl mt-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📝 Buat Pesanan - {{ $mitra->nama_toko }}</h1>

    <form action="{{ route('pelanggan.pesanan.store', ['mitra' => $mitra->id]) }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Jenis Layanan</label>
                <div class="flex flex-wrap gap-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="checkboxReguler" name="jenis_layanan[]" value="Kiloan Reguler" class="form-checkbox text-blue-600">
                        <span class="ml-2">Kiloan Reguler</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="checkboxEkspres" name="jenis_layanan[]" value="Kiloan Ekspres" class="form-checkbox text-blue-600">
                        <span class="ml-2">Kiloan Ekspres</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="checkboxSatuan" name="jenis_layanan[]" value="Satuan" class="form-checkbox text-blue-600">
                        <span class="ml-2">Layanan Satuan</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="tanggal_pesan" class="block font-medium text-gray-700 mb-1">Tanggal Pesan</label>
                <input type="date" name="tanggal_pesan" id="tanggal_pesan" class="w-full rounded-lg border-gray-300 shadow-sm" required>
            </div>

            <div>
                <label for="tipe_dp_wajib" class="block font-medium text-gray-700 mb-1">DP Wajib</label>
                <input type="text" id="tipe_dp_wajib" name="tipe_dp_wajib" readonly class="w-full rounded-lg border-gray-300 shadow-sm bg-gray-100">
            </div>

            <div>
                <label for="tipe_bisa_lunas" class="block font-medium text-gray-700 mb-1">Bisa Lunas</label>
                <input type="text" id="tipe_bisa_lunas" name="tipe_bisa_lunas" readonly class="w-full rounded-lg border-gray-300 shadow-sm bg-gray-100">
            </div>

            <div class="md:col-span-2">
                <label for="catatan_pesanan" class="block font-medium text-gray-700 mb-1">Catatan Pesanan</label>
                <textarea name="catatan_pesanan" id="catatan_pesanan" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm"></textarea>
            </div>
        </div>

        <div class="border-t border-gray-200 my-8"></div>

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">🚚 Pengiriman</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="opsi_jemput" class="block font-medium text-gray-700 mb-1">Opsi Jemput</label>
                <select name="opsi_jemput" id="opsi_jemput" class="w-full rounded-lg border-gray-300 shadow-sm">
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>

            <div>
                <label for="jadwal_jemput" class="block font-medium text-gray-700 mb-1">Jadwal Jemput</label>
                <input type="datetime-local" name="jadwal_jemput" id="jadwal_jemput" class="w-full rounded-lg border-gray-300 shadow-sm">
            </div>

            <div>
                <label for="opsi_antar" class="block font-medium text-gray-700 mb-1">Opsi Antar</label>
                <select name="opsi_antar" id="opsi_antar" class="w-full rounded-lg border-gray-300 shadow-sm">
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>

            <div>
                <label for="jadwal_antar" class="block font-medium text-gray-700 mb-1">Jadwal Antar</label>
                <input type="datetime-local" name="jadwal_antar" id="jadwal_antar" class="w-full rounded-lg border-gray-300 shadow-sm">
            </div>

            <div class="md:col-span-2">
                <label for="catatan_pengiriman" class="block font-medium text-gray-700 mb-1">Catatan Pengiriman</label>
                <textarea name="catatan_pengiriman" id="catatan_pengiriman" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm"></textarea>
            </div>
        </div>

        <div id="layanan-kiloan" class="mt-8 hidden">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">🧺 Layanan Kiloan</h2>
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <select name="layanan_mitra_kiloan_id" class="w-full rounded-lg border-gray-300 shadow-sm kiloan-select" required>
                        @foreach ($mitra->layananMitraKiloan as $layanan)
                            <option value="{{ $layanan->id }}" data-durasi="{{ $layanan->durasi_hari }}">{{ $layanan->layananKiloan->nama_paket }} (Rp {{ $layanan->harga_per_kg }}/kg)</option>
                        @endforeach
                    </select>
                    <input type="number" name="berat_sementara" min="1" step="1" placeholder="Berat (kg)" class="w-full rounded-lg border-gray-300 shadow-sm" required oninput="this.value = Math.round(this.value);" />
                </div>
            </div>
        </div>

        <div id="layanan-satuan" class="mt-8 hidden">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">🧦 Layanan Satuan</h2>
            <div id="satuan-items" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <select name="satuan[0][layanan_mitra_satuan_id]" class="w-full rounded-lg border-gray-300 shadow-sm satuan-select">
                        @foreach ($mitra->layananMitraSatuan as $layanan)
                            <option value="{{ $layanan->id }}" data-durasi="{{ $layanan->durasi_hari }}">{{ $layanan->layananSatuan->nama_layanan }} (Rp {{ $layanan->harga_per_item }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="satuan[0][jumlah_item]" min="1" placeholder="Jumlah Item" class="w-full rounded-lg border-gray-300 shadow-sm" required />
                </div>
            </div>
            <button type="button" id="add-satuan-item" class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Tambah Item Satuan</button>
        </div>

        <div class="text-right mt-10">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">Buat Pesanan</button>
        </div>
    </form>
</div>

<script>
    const checkboxReguler = document.getElementById('checkboxReguler');
    const checkboxEkspres = document.getElementById('checkboxEkspres');
    const checkboxSatuan = document.getElementById('checkboxSatuan');
    const layananKiloan = document.getElementById('layanan-kiloan');
    const layananSatuan = document.getElementById('layanan-satuan');
    const dpWajib = document.getElementById('tipe_dp_wajib');
    const bisaLunas = document.getElementById('tipe_bisa_lunas');
    const satuanItems = document.getElementById('satuan-items');
    const addSatuanItemBtn = document.getElementById('add-satuan-item');

    // Fungsi untuk memeriksa apakah waktu berada dalam jam operasional
    function isWithinOperationalHours(datetime, jamOperasionals) {
        const date = new Date(datetime);
        const hari = date.toLocaleDateString('id-ID', { weekday: 'long' });
        const jam = date.getHours() + ':' + String(date.getMinutes()).padStart(2, '0');

        const jamHariIni = jamOperasionals.find(j => j.hari_buka.toLowerCase() === hari.toLowerCase());
        if (!jamHariIni) return false;

        return jam >= jamHariIni.jam_buka && jam <= jamHariIni.jam_tutup;
    }

    function updateLayananView() {
        layananKiloan.classList.toggle('hidden', !(checkboxReguler.checked || checkboxEkspres.checked));
        layananSatuan.classList.toggle('hidden', !checkboxSatuan.checked);

        if (checkboxEkspres.checked) {
            checkboxReguler.checked = false;
            checkboxSatuan.checked = false;
            checkboxSatuan.disabled = true;
        } else {
            checkboxSatuan.disabled = false;
        }

        if (checkboxEkspres.checked || (checkboxReguler.checked && checkboxSatuan.checked)) {
            dpWajib.value = 'Ya';
            bisaLunas.value = 'Tidak';
        } else if (checkboxReguler.checked) {
            dpWajib.value = 'Ya';
            bisaLunas.value = 'Tidak';
        } else if (checkboxSatuan.checked) {
            dpWajib.value = 'Tidak';
            bisaLunas.value = 'Ya';
        } else {
            dpWajib.value = '-';
            bisaLunas.value = '-';
        }
    }

    [checkboxReguler, checkboxEkspres, checkboxSatuan].forEach(cb => {
        cb.addEventListener('change', updateLayananView);
    });

    window.addEventListener('load', updateLayananView);

    // Tambah Item Satuan
    let satuanIndex = 0;
    addSatuanItemBtn.addEventListener('click', () => {
        satuanIndex++;
        const newItem = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <select name="satuan[${satuanIndex}][layanan_mitra_satuan_id]" class="w-full rounded-lg border-gray-300 shadow-sm satuan-select">
                    @foreach ($mitra->layananMitraSatuan as $layanan)
                        <option value="{{ $layanan->id }}" data-durasi="{{ $layanan->durasi_hari }}">{{ $layanan->layananSatuan->nama_layanan }} (Rp {{ $layanan->harga_per_item }})</option>
                    @endforeach
                </select>
                <input type="number" name="satuan[${satuanIndex}][jumlah_item]" min="1" placeholder="Jumlah Item" class="w-full rounded-lg border-gray-300 shadow-sm" required />
            </div>
        `;
        satuanItems.insertAdjacentHTML('beforeend', newItem);
    });

    // Jadwal Antar Minimum
    function hitungTanggalSelesai(tanggalPesan, durasiHari) {
        const date = new Date(tanggalPesan);
        date.setDate(date.getDate() + durasiHari);
        return date.toISOString().slice(0, 16);
    }

    function updateJadwalAntarMin() {
        const tanggalPesan = document.getElementById('tanggal_pesan').value;
        let maxDurasi = 0;

        const kiloanSelect = document.querySelector('.kiloan-select');
        if (kiloanSelect) {
            const durasi = parseInt(kiloanSelect.options[kiloanSelect.selectedIndex].dataset.durasi || 0);
            if (durasi > maxDurasi) maxDurasi = durasi;
        }

        document.querySelectorAll('.satuan-select').forEach(select => {
            const durasi = parseInt(select.options[select.selectedIndex].dataset.durasi || 0);
            if (durasi > maxDurasi) maxDurasi = durasi;
        });

        if (tanggalPesan && maxDurasi > 0) {
            const minTanggalAntar = hitungTanggalSelesai(tanggalPesan, maxDurasi);
            document.getElementById('jadwal_antar').min = minTanggalAntar;
        }
    }

    document.getElementById('tanggal_pesan').addEventListener('change', updateJadwalAntarMin);
    document.addEventListener('change', updateJadwalAntarMin);
</script>
@endsection