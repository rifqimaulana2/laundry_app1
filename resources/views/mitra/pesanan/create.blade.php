@extends('layouts.mitra')

@section('content')
    <div class="max-w-3xl mx-auto mt-10">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Pesanan</h1>
            <form action="{{ route('mitra.pesanan.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Pelanggan</label>
                    <select name="walkin_customer_id" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3">
                        <option value="">Pilih Pelanggan Walk-in</option>
                        @foreach ($walkinCustomers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Jenis Pesanan</label>
                    <select name="jenis_pesanan" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                        <option value="Kiloan">Kiloan</option>
                        <option value="Satuan">Satuan</option>
                        <option value="Gabungan">Gabungan</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Opsi Jemput</label>
                    <select name="opsi_jemput" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Jadwal Jemput</label>
                    <input type="datetime-local" name="jadwal_jemput" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Opsi Antar</label>
                    <select name="opsi_antar" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Jadwal Antar</label>
                    <input type="datetime-local" name="jadwal_antar" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Catatan Pesanan</label>
                    <textarea name="catatan_pesanan" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3"></textarea>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Catatan Pengiriman</label>
                    <textarea name="catatan_pengiriman" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3"></textarea>
                </div>
                <h3 class="text-lg font-bold text-gray-700 mt-6 mb-2">Detail Kiloan</h3>
                <div id="detail-kiloan">
                    <div class="space-y-2">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Layanan Kiloan</label>
                        <select name="detail_kiloan[0][layanan_mitra_kiloan_id]" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3">
                            <option value="">Pilih Layanan</option>
                            @foreach ($layananKiloans as $layanan)
                                <option value="{{ $layanan->id }}">{{ $layanan->layananKiloan->nama_paket }}</option>
                            @endforeach
                        </select>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Berat Sementara (kg)</label>
                        <input type="number" name="detail_kiloan[0][berat_sementara]" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" step="0.01">
                    </div>
                </div>
                <button type="button" class="w-full py-2 px-4 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition mb-3" onclick="addDetailKiloan()">Tambah Detail Kiloan</button>
                <h3 class="text-lg font-bold text-gray-700 mt-6 mb-2">Detail Satuan</h3>
                <div id="detail-satuan">
                    <div class="space-y-2">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Layanan Satuan</label>
                        <select name="detail_satuan[0][layanan_mitra_satuan_id]" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3">
                            <option value="">Pilih Layanan</option>
                            @foreach ($layananSatuans as $layanan)
                                <option value="{{ $layanan->id }}">{{ $layanan->layananSatuan->nama_layanan }}</option>
                            @endforeach
                        </select>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Jumlah Item</label>
                        <input type="number" name="detail_satuan[0][jumlah_item]" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3">
                    </div>
                </div>
                <button type="button" class="w-full py-2 px-4 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition mb-3" onclick="addDetailSatuan()">Tambah Detail Satuan</button>
                <button type="submit" class="w-full py-2 px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">Simpan</button>
            </form>
        </div>
    </div>
    <script>
        let kiloanCount = 1;
        let satuanCount = 1;

        function addDetailKiloan() {
            const container = document.getElementById('detail-kiloan');
            const html = `
                <div class="form-group">
                    <label>Layanan Kiloan</label>
                    <select name="detail_kiloan[${kiloanCount}][layanan_mitra_kiloan_id]" class="form-control">
                        <option value="">Pilih Layanan</option>
                        @foreach ($layananKiloans as $layanan)
                            <option value="{{ $layanan->id }}">{{ $layanan->layananKiloan->nama_paket }}</option>
                        @endforeach
                    </select>
                    <label>Berat Sementara (kg)</label>
                    <input type="number" name="detail_kiloan[${kiloanCount}][berat_sementara]" class="form-control" step="0.01">
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
            kiloanCount++;
        }

        function addDetailSatuan() {
            const container = document.getElementById('detail-satuan');
            const html = `
                <div class="form-group">
                    <label>Layanan Satuan</label>
                    <select name="detail_satuan[${satuanCount}][layanan_mitra_satuan_id]" class="form-control">
                        <option value="">Pilih Layanan</option>
                        @foreach ($layananSatuans as $layanan)
                            <option value="{{ $layanan->id }}">{{ $layanan->layananSatuan->nama_layanan }}</option>
                        @endforeach
                    </select>
                    <label>Jumlah Item</label>
                    <input type="number" name="detail_satuan[${satuanCount}][jumlah_item]" class="form-control">
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
            satuanCount++;
        }
    </script>
@endsection