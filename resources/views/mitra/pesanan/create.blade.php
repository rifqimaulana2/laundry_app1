@extends('layouts.mitra')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <div class="bg-white rounded-3xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Pesanan</h1>
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('mitra.pesanan.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Jenis Pelanggan</label>
                <select id="jenis_pelanggan" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500">
                    <option value="">Pilih Jenis Pelanggan</option>
                    <option value="terdaftar">Pelanggan Terdaftar</option>
                    <option value="walkin">Pelanggan Walk-in</option>
                </select>
                @error('user_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div id="form-user" class="hidden">
                <label class="block mb-2 text-sm font-medium text-gray-700">Pelanggan Terdaftar</label>
                <select name="user_id" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500">
                    <option value="">Pilih Pelanggan</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="form-walkin" class="hidden">
                <label class="block mb-2 text-sm font-medium text-gray-700">Pelanggan Walk-in</label>
                <select name="walkin_customer_id" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500">
                    <option value="">Pilih Walk-in Customer</option>
                    @foreach ($walkinCustomers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Jenis Pesanan</label>
                <select name="jenis_pesanan" id="jenis_pesanan" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500" required>
                    <option value="">Pilih Jenis Pesanan</option>
                    <option value="Kiloan Reguler">Kiloan Reguler</option>
                    <option value="Kiloan Ekspres">Kiloan Ekspres</option>
                    <option value="Satuan">Satuan</option>
                    <option value="Kiloan + Satuan">Kiloan + Satuan</option>
                </select>
                @error('jenis_pesanan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div id="opsi_pembayaran_form" class="hidden">
                <label class="block mb-2 text-sm font-medium text-gray-700">Opsi Pembayaran</label>
                <select name="opsi_pembayaran" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500">
                    <option value="Lunas">Lunas</option>
                    <option value="DP">DP</option>
                </select>
                @error('opsi_pembayaran')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Opsi Jemput</label>
                <select name="opsi_jemput" id="opsi_jemput" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500" required>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>

            <div id="jadwal_jemput_form" class="hidden">
                <label class="block mb-2 text-sm font-medium text-gray-700">Jadwal Jemput</label>
                <input type="datetime-local" name="jadwal_jemput" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500">
                @error('jadwal_jemput')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Opsi Antar</label>
                <select name="opsi_antar" id="opsi_antar" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500" required>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>

            <div id="jadwal_antar_form" class="hidden">
                <label class="block mb-2 text-sm font-medium text-gray-700">Jadwal Antar</label>
                <input type="datetime-local" name="jadwal_antar" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500">
                @error('jadwal_antar')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Catatan Pesanan</label>
                <textarea name="catatan_pesanan" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500"></textarea>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Catatan Pengiriman</label>
                <textarea name="catatan_pengiriman" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500"></textarea>
            </div>

            <div id="detail_kiloan_form" class="hidden">
                <h3 class="text-lg font-bold text-gray-700 mt-6 mb-2">Detail Kiloan</h3>
                <div class="grid gap-2">
                    <label>Layanan Kiloan</label>
                    <select name="layanan_mitra_kiloan_id" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500">
                        <option value="">Pilih Layanan</option>
                        @foreach ($layananKiloans as $layanan)
                            <option value="{{ $layanan->id }}">{{ $layanan->layananKiloan->nama_paket }} (Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}/kg)</option>
                        @endforeach
                    </select>
                    @error('layanan_mitra_kiloan_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <label>Berat Sementara (kg)</label>
                    <input type="number" name="berat_sementara" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500" min="1" step="0.1">
                    @error('berat_sementara')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div id="detail_satuan_form" class="hidden">
                <h3 class="text-lg font-bold text-gray-700 mt-6 mb-2">Detail Satuan</h3>
                <div id="detail-satuan" class="space-y-3">
                    <div class="grid gap-2">
                        <label>Layanan Satuan</label>
                        <select name="detail_satuan[0][layanan_mitra_satuan_id]" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500">
                            <option value="">Pilih Layanan</option>
                            @foreach ($layananSatuans as $layanan)
                                <option value="{{ $layanan->id }}">{{ $layanan->layananSatuan->nama_layanan }} (Rp {{ number_format($layanan->harga_per_item, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                        <label>Jumlah Item</label>
                        <input type="number" name="detail_satuan[0][jumlah_item]" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500" min="1" step="1">
                    </div>
                </div>
                <button type="button" onclick="addDetailSatuan()" class="w-full py-2 px-4 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition mb-3">Tambah Detail Satuan</button>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">Simpan</button>
        </form>
    </div>
</div>

<script>
    let satuanCount = 1;
    const layananSatuans = @json($layananSatuans);

    function addDetailSatuan() {
        const container = document.getElementById('detail-satuan');
        const options = layananSatuans.map(l => `<option value="${l.id}">${l.layanan_satuan.nama_layanan} (Rp ${l.harga_per_item.toLocaleString('id-ID')})</option>`).join('');
        const html = `
            <div class="grid gap-2">
                <label>Layanan Satuan</label>
                <select name="detail_satuan[${satuanCount}][layanan_mitra_satuan_id]" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500">
                    <option value="">Pilih Layanan</option>
                    ${options}
                </select>
                <label>Jumlah Item</label>
                <input type="number" name="detail_satuan[${satuanCount}][jumlah_item]" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:ring-green-500 focus:border-green-500" min="1" step="1">
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        satuanCount++;
    }

    document.getElementById('jenis_pelanggan').addEventListener('change', function () {
        document.getElementById('form-user').classList.add('hidden');
        document.getElementById('form-walkin').classList.add('hidden');
        if (this.value === 'terdaftar') document.getElementById('form-user').classList.remove('hidden');
        else if (this.value === 'walkin') document.getElementById('form-walkin').classList.remove('hidden');
    });

    document.getElementById('jenis_pesanan').addEventListener('change', function () {
        const detailKiloan = document.getElementById('detail_kiloan_form');
        const detailSatuan = document.getElementById('detail_satuan_form');
        const opsiPembayaran = document.getElementById('opsi_pembayaran_form');
        detailKiloan.classList.add('hidden');
        detailSatuan.classList.add('hidden');
        opsiPembayaran.classList.add('hidden');
        if (['Kiloan Reguler', 'Kiloan Ekspres', 'Kiloan + Satuan'].includes(this.value)) detailKiloan.classList.remove('hidden');
        if (['Satuan', 'Kiloan + Satuan'].includes(this.value)) detailSatuan.classList.remove('hidden');
        if (this.value === 'Satuan') opsiPembayaran.classList.remove('hidden');
    });

    document.getElementById('opsi_jemput').addEventListener('change', function () {
        const jadwalJemput = document.getElementById('jadwal_jemput_form');
        jadwalJemput.classList.toggle('hidden', this.value !== 'Ya');
    });

    document.getElementById('opsi_antar').addEventListener('change', function () {
        const jadwalAntar = document.getElementById('jadwal_antar_form');
        jadwalAntar.classList.toggle('hidden', this.value !== 'Ya');
    });
</script>
@endsection