@extends('layouts.pelanggan')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded-2xl shadow-lg mt-10">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 flex items-center gap-2">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Buat Pesanan - {{ $mitra->nama_toko }}
    </h1>

    <form action="{{ route('pelanggan.pesanan.store', ['mitra' => $mitra->id]) }}" method="POST" id="pesananForm">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan</label>
                <div class="flex flex-wrap gap-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="checkboxReguler" name="jenis_layanan[]" value="Kiloan Reguler" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                        <span class="ml-2 text-gray-600">Kiloan Reguler</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="checkboxEkspres" name="jenis_layanan[]" value="Kiloan Ekspres" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                        <span class="ml-2 text-gray-600">Kiloan Ekspres</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="checkboxSatuan" name="jenis_layanan[]" value="Satuan" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                        <span class="ml-2 text-gray-600">Layanan Satuan</span>
                    </label>
                </div>
                @error('jenis_layanan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tanggal_pesan" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pesan</label>
                <input type="date" name="tanggal_pesan" id="tanggal_pesan" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required min="{{ now()->format('Y-m-d') }}">
                @error('tanggal_pesan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tipe_dp_wajib" class="block text-sm font-medium text-gray-700 mb-1">DP Wajib</label>
                <input type="text" id="tipe_dp_wajib" name="tipe_dp_wajib" readonly class="w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm text-gray-600">
            </div>

            <div>
                <label for="tipe_bisa_lunas" class="block text-sm font-medium text-gray-700 mb-1">Bisa Lunas</label>
                <input type="text" id="tipe_bisa_lunas" name="tipe_bisa_lunas" readonly class="w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm text-gray-600">
            </div>

            <div class="md:col-span-2">
                <label for="catatan_pesanan" class="block text-sm font-medium text-gray-700 mb-1">Catatan Pesanan</label>
                <textarea name="catatan_pesanan" id="catatan_pesanan" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
        </div>

        <div class="border-t border-gray-200 my-8"></div>

        <h2 class="text-xl md:text-2xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
            </svg>
            Pengiriman
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="opsi_jemput" class="block text-sm font-medium text-gray-700 mb-1">Opsi Jemput</label>
                <select name="opsi_jemput" id="opsi_jemput" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>

            <div>
                <label for="jadwal_jemput" class="block text-sm font-medium text-gray-700 mb-1">Jadwal Jemput</label>
                <input type="datetime-local" name="jadwal_jemput" id="jadwal_jemput" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('jadwal_jemput')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="opsi_antar" class="block text-sm font-medium text-gray-700 mb-1">Opsi Antar</label>
                <select name="opsi_antar" id="opsi_antar" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>

            <div>
                <label for="jadwal_antar" class="block text-sm font-medium text-gray-700 mb-1">Jadwal Antar</label>
                <input type="datetime-local" name="jadwal_antar" id="jadwal_antar" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('jadwal_antar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="catatan_pengiriman" class="block text-sm font-medium text-gray-700 mb-1">Catatan Pengiriman</label>
                <textarea name="catatan_pengiriman" id="catatan_pengiriman" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
        </div>

        {{-- Layanan Kiloan --}}
        <div id="layanan-kiloan" class="mt-8 hidden">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                </svg>
                Layanan Kiloan
            </h2>
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <select name="layanan_mitra_kiloan_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 kiloan-select">
                        @foreach ($mitra->layananMitraKiloan as $layanan)
                            <option value="{{ $layanan->id }}" data-durasi="{{ $layanan->durasi_hari }}">{{ $layanan->layananKiloan->nama_paket }} (Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}/kg)</option>
                        @endforeach
                    </select>
                    <input type="number" name="berat_sementara" min="1" step="1" placeholder="Berat (kg)" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" oninput="this.value = Math.round(this.value);" />
                </div>
            </div>
            @error('layanan_mitra_kiloan_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('berat_sementara')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Layanan Satuan --}}
        <div id="layanan-satuan" class="mt-8 hidden">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2m0 0l3-3m0 0l3 3m-6 0v6"></path>
                </svg>
                Layanan Satuan
            </h2>
            <div id="satuan-items" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 satuan-item">
                    <select name="satuan[0][layanan_mitra_satuan_id]" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 satuan-select">
                        @foreach ($mitra->layananMitraSatuan as $layanan)
                            <option value="{{ $layanan->id }}" data-durasi="{{ $layanan->durasi_hari }}">{{ $layanan->layananSatuan->nama_layanan }} (Rp {{ number_format($layanan->harga_per_item, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="satuan[0][jumlah_item]" min="1" placeholder="Jumlah Item" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 satuan-jumlah" />
                </div>
            </div>
            <button type="button" id="add-satuan-item" class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Tambah Item Satuan</button>
            @error('satuan.*.layanan_mitra_satuan_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('satuan.*.jumlah_item')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-right mt-10">
            <button type="button" onclick="console.log(Object.fromEntries(new FormData(document.getElementById('pesananForm'))))" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition mr-4">Debug Form</button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">Buat Pesanan</button>
        </div>
    </form>
</div>

<script>
    const jamOperasionals = @json($mitra->jamOperasionals);

    function isWithinOperationalHours(datetime, jamOperasionals) {
        const date = new Date(datetime);
        const hari = date.toLocaleDateString('id-ID', { weekday: 'long' }).toLowerCase();
        const jam = date.getHours() + ':' + String(date.getMinutes()).padStart(2, '0');
        const jamHariIni = jamOperasionals.find(j => j.hari_buka.toLowerCase() === hari);
        if (!jamHariIni) return false;
        return jam >= jamHariIni.jam_buka && jam <= jamHariIni.jam_tutup;
    }

    function hitungTanggalSelesai(tanggalPesan, durasiHari) {
        const date = new Date(tanggalPesan);
        date.setDate(date.getDate() + durasiHari);
        return date.toISOString().slice(0, 16);
    }

    function updateLayananView() {
        const checkboxReguler = document.getElementById('checkboxReguler');
        const checkboxEkspres = document.getElementById('checkboxEkspres');
        const checkboxSatuan = document.getElementById('checkboxSatuan');
        const layananKiloan = document.getElementById('layanan-kiloan');
        const layananSatuan = document.getElementById('layanan-satuan');
        const dpWajib = document.getElementById('tipe_dp_wajib');
        const bisaLunas = document.getElementById('tipe_bisa_lunas');

        // Tampilkan/sembunyikan section berdasarkan checkbox
        layananKiloan.classList.toggle('hidden', !(checkboxReguler.checked || checkboxEkspres.checked));
        layananSatuan.classList.toggle('hidden', !checkboxSatuan.checked);

        // Atur atribut required
        const kiloanInputs = layananKiloan.querySelectorAll('input, select');
        kiloanInputs.forEach(input => input.toggleAttribute('required', checkboxReguler.checked || checkboxEkspres.checked));
        const satuanInputs = layananSatuan.querySelectorAll('input, select');
        satuanInputs.forEach(input => input.toggleAttribute('required', checkboxSatuan.checked));

        // Nonaktifkan checkbox lain jika Kiloan Ekspres dipilih
        if (checkboxEkspres.checked) {
            checkboxReguler.checked = false;
            checkboxSatuan.checked = false;
            checkboxSatuan.disabled = true;
            layananSatuan.classList.add('hidden');
            satuanInputs.forEach(input => input.removeAttribute('required'));
        } else {
            checkboxSatuan.disabled = false;
        }

        // Atur tipe_dp_wajib dan tipe_bisa_lunas
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

        updateJadwalConstraints();
    }

    function updateJadwalConstraints() {
        const tanggalPesanInput = document.getElementById('tanggal_pesan');
        const jadwalJemputInput = document.getElementById('jadwal_jemput');
        const jadwalAntarInput = document.getElementById('jadwal_antar');
        const opsiJemput = document.getElementById('opsi_jemput').value;
        const opsiAntar = document.getElementById('opsi_antar').value;

        if (!tanggalPesanInput.value) return;

        let maxDurasi = 0;
        const kiloanSelect = document.querySelector('.kiloan-select');
        if (kiloanSelect && (document.getElementById('checkboxReguler').checked || document.getElementById('checkboxEkspres').checked)) {
            const durasi = parseInt(kiloanSelect.options[kiloanSelect.selectedIndex].dataset.durasi || 0);
            if (durasi > maxDurasi) maxDurasi = durasi;
        }
        document.querySelectorAll('.satuan-select').forEach(select => {
            const durasi = parseInt(select.options[select.selectedIndex].dataset.durasi || 0);
            if (durasi > maxDurasi) maxDurasi = durasi;
        });

        if (opsiJemput === 'Ya') {
            jadwalJemputInput.required = true;
        } else {
            jadwalJemputInput.required = false;
            jadwalJemputInput.value = '';
        }

        if (opsiAntar === 'Ya' && maxDurasi > 0) {
            jadwalAntarInput.required = true;
            jadwalAntarInput.min = hitungTanggalSelesai(tanggalPesanInput.value, maxDurasi);
        } else {
            jadwalAntarInput.required = false;
            jadwalAntarInput.value = '';
        }
    }

    function validateOperationalHours(inputId) {
        const input = document.getElementById(inputId);
        if (!input.value) return;
        if (!isWithinOperationalHours(input.value, jamOperasionals)) {
            input.setCustomValidity('Jadwal ini di luar jam operasional mitra.');
        } else {
            input.setCustomValidity('');
        }
    }

    // Tambah item satuan
    document.getElementById('add-satuan-item').addEventListener('click', function() {
        const satuanItems = document.getElementById('satuan-items');
        const index = satuanItems.children.length;
        const newItem = document.createElement('div');
        newItem.className = 'grid grid-cols-1 md:grid-cols-2 gap-4 satuan-item';
        newItem.innerHTML = `
            <select name="satuan[${index}][layanan_mitra_satuan_id]" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 satuan-select">
                @foreach ($mitra->layananMitraSatuan as $layanan)
                    <option value="{{ $layanan->id }}" data-durasi="{{ $layanan->durasi_hari }}">{{ $layanan->layananSatuan->nama_layanan }} (Rp {{ number_format($layanan->harga_per_item, 0, ',', '.') }})</option>
                @endforeach
            </select>
            <input type="number" name="satuan[${index}][jumlah_item]" min="1" placeholder="Jumlah Item" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 satuan-jumlah" />
        `;
        satuanItems.appendChild(newItem);
        updateJadwalConstraints();
    });

    // Hapus field satuan jika tidak dipilih saat submit
    document.getElementById('pesananForm').addEventListener('submit', function(e) {
        const checkboxSatuan = document.getElementById('checkboxSatuan');
        if (!checkboxSatuan.checked) {
            const satuanSection = document.getElementById('layanan-satuan');
            satuanSection.remove();
        } else {
            // Validasi jumlah_item untuk setiap satuan
            const jumlahInputs = document.querySelectorAll('.satuan-jumlah');
            for (let input of jumlahInputs) {
                if (!input.value || input.value < 1) {
                    e.preventDefault();
                    input.setCustomValidity('Jumlah item harus diisi dan minimal 1.');
                    input.reportValidity();
                    return;
                }
            }
        }
    });

    // Event listeners
    document.getElementById('checkboxReguler').addEventListener('change', updateLayananView);
    document.getElementById('checkboxEkspres').addEventListener('change', updateLayananView);
    document.getElementById('checkboxSatuan').addEventListener('change', updateLayananView);
    document.getElementById('tanggal_pesan').addEventListener('change', updateJadwalConstraints);
    document.getElementById('opsi_jemput').addEventListener('change', updateJadwalConstraints);
    document.getElementById('opsi_antar').addEventListener('change', updateJadwalConstraints);
    document.getElementById('jadwal_jemput').addEventListener('change', () => validateOperationalHours('jadwal_jemput'));
    document.getElementById('jadwal_antar').addEventListener('change', () => validateOperationalHours('jadwal_antar'));

    // Inisialisasi
    updateLayananView();
</script>
@endsection