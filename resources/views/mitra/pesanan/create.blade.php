@extends('layouts.mitra')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="p-6 max-w-5xl mx-auto bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">Buat Pesanan Baru</h1>

    <form action="{{ route('mitra.pesanan.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- TIPE PELANGGAN --}}
        <div>
            <label class="block font-medium mb-1">Tipe Pelanggan</label>
            <select name="pelanggan_tipe" id="pelanggan_tipe" class="border rounded w-full p-2">
                <option value="online">Pelanggan Terdaftar</option>
                <option value="walkin">Walk-in Baru</option>
            </select>
        </div>

        {{-- PELANGGAN ONLINE --}}
        <div id="online_box">
            <label class="block font-medium mb-1">Pilih Pelanggan</label>
            <select name="user_id" class="border rounded w-full p-2">
                <option value="">-- Pilih pelanggan --</option>
                @foreach($pelanggans as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>

        {{-- WALKIN --}}
        <div id="walkin_box" class="hidden">
            <label class="block font-medium mb-1">Data Pelanggan Walk-in</label>
            <input type="text" name="nama" placeholder="Nama" class="border rounded w-full p-2 mb-2">
            <input type="text" name="alamat" placeholder="Alamat" class="border rounded w-full p-2 mb-2">
            <input type="text" name="no_tlp" placeholder="No Telepon" class="border rounded w-full p-2">
        </div>

        {{-- JENIS PESANAN --}}
        <div>
            <label class="block font-medium mb-1">Jenis Pesanan</label>
            <select name="jenis_pesanan" id="jenis_pesanan" class="border rounded w-full p-2">
                <option value="Kiloan">Kiloan</option>
                <option value="Satuan">Satuan</option>
                <option value="Kiloan + Satuan">Kiloan + Satuan</option>
            </select>
        </div>

        {{-- DETAIL KILOAN --}}
        <div id="kiloan_section">
            <label class="block font-medium mb-1">Detail Kiloan</label>
            <div id="kiloan_items" class="space-y-2">
                <div class="flex gap-2">
                    <select name="kiloan[0][layanan_id]" class="border rounded p-2 w-1/2">
                        <option value="">-- Pilih paket --</option>
                        @foreach($layananKiloan as $lk)
                            <option value="{{ $lk->id }}">{{ $lk->layananKiloan->nama_paket }} — Rp{{ number_format($lk->harga_per_kg,0,',','.') }}/kg</option>
                        @endforeach
                    </select>
                    <input type="number" step="0.1" name="kiloan[0][berat]" placeholder="Berat (kg)" class="border rounded p-2 w-1/4">
                    <input type="number" name="kiloan[0][harga]" placeholder="Harga" class="border rounded p-2 w-1/4">
                </div>
            </div>
            <button type="button" id="add_kiloan" class="mt-2 bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">+ Tambah Kiloan</button>
        </div>

        {{-- DETAIL SATUAN --}}
        <div id="satuan_section" class="hidden">
            <label class="block font-medium mb-1">Detail Satuan</label>
            <div id="satuan_items" class="space-y-2">
                <div class="flex gap-2">
                    <select name="satuan[0][layanan_id]" class="border rounded p-2 w-1/2">
                        <option value="">-- Pilih layanan --</option>
                        @foreach($layananSatuan as $ls)
                            <option value="{{ $ls->id }}">{{ $ls->layananSatuan->nama_layanan }} — Rp{{ number_format($ls->harga_per_item,0,',','.') }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="satuan[0][jumlah]" placeholder="Jumlah" class="border rounded p-2 w-1/4">
                    <input type="number" name="satuan[0][harga]" placeholder="Harga" class="border rounded p-2 w-1/4">
                </div>
            </div>
            <button type="button" id="add_satuan" class="mt-2 bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">+ Tambah Satuan</button>
        </div>

        {{-- OPSI JEMPUT --}}
        <div>
            <label class="block font-medium mb-1">Opsi Jemput</label>
            <select name="opsi_jemput" class="border rounded w-full p-2 mb-2">
                <option value="Tidak">Tidak</option>
                <option value="Ya">Ya</option>
            </select>
            <input type="datetime-local" name="jadwal_jemput" class="border rounded w-full p-2">
        </div>

        {{-- OPSI ANTAR --}}
        <div>
            <label class="block font-medium mb-1">Opsi Antar</label>
            <select name="opsi_antar" class="border rounded w-full p-2 mb-2">
                <option value="Tidak">Tidak</option>
                <option value="Ya">Ya</option>
            </select>
            <input type="datetime-local" name="jadwal_antar" class="border rounded w-full p-2">
        </div>

        {{-- PEMBAYARAN --}}
        <div>
            <label class="block font-medium mb-1">DP Dibayar</label>
            <input type="number" name="dp_dibayar" placeholder="0" class="border rounded w-full p-2 mb-2">
            <label class="block font-medium mb-1">Metode Bayar</label>
            <select name="metode_bayar" class="border rounded w-full p-2">
                <option value="transfer">Transfer</option>
                <option value="tunai">Tunai</option>
            </select>
        </div>

        {{-- CATATAN --}}
        <div>
            <label class="block font-medium mb-1">Catatan Pesanan</label>
            <textarea name="catatan_pesanan" rows="3" class="border rounded w-full p-2"></textarea>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('mitra.pesanan.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
</div>

<script>
    const pelangganTipe = document.getElementById('pelanggan_tipe');
    const onlineBox = document.getElementById('online_box');
    const walkinBox = document.getElementById('walkin_box');
    const jenisPesanan = document.getElementById('jenis_pesanan');
    const kiloanSection = document.getElementById('kiloan_section');
    const satuanSection = document.getElementById('satuan_section');

    pelangganTipe.addEventListener('change', () => {
        walkinBox.classList.toggle('hidden', pelangganTipe.value !== 'walkin');
        onlineBox.classList.toggle('hidden', pelangganTipe.value === 'walkin');
    });

    jenisPesanan.addEventListener('change', () => {
        if (jenisPesanan.value === 'Kiloan') {
            kiloanSection.classList.remove('hidden');
            satuanSection.classList.add('hidden');
        } else if (jenisPesanan.value === 'Satuan') {
            kiloanSection.classList.add('hidden');
            satuanSection.classList.remove('hidden');
        } else {
            kiloanSection.classList.remove('hidden');
            satuanSection.classList.remove('hidden');
        }
    });

    let kiloanIndex = 1;
    document.getElementById('add_kiloan').addEventListener('click', () => {
        const container = document.getElementById('kiloan_items');
        const html = `
            <div class="flex gap-2">
                <select name="kiloan[${kiloanIndex}][layanan_id]" class="border rounded p-2 w-1/2">
                    @foreach($layananKiloan as $lk)
                        <option value="{{ $lk->id }}">{{ $lk->layananKiloan->nama_paket }} — Rp{{ number_format($lk->harga_per_kg,0,',','.') }}/kg</option>
                    @endforeach
                </select>
                <input type="number" step="0.1" name="kiloan[${kiloanIndex}][berat]" placeholder="Berat (kg)" class="border rounded p-2 w-1/4">
                <input type="number" name="kiloan[${kiloanIndex}][harga]" placeholder="Harga" class="border rounded p-2 w-1/4">
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        kiloanIndex++;
    });

    let satuanIndex = 1;
    document.getElementById('add_satuan').addEventListener('click', () => {
        const container = document.getElementById('satuan_items');
        const html = `
            <div class="flex gap-2">
                <select name="satuan[${satuanIndex}][layanan_id]" class="border rounded p-2 w-1/2">
                    @foreach($layananSatuan as $ls)
                        <option value="{{ $ls->id }}">{{ $ls->layananSatuan->nama_layanan }} — Rp{{ number_format($ls->harga_per_item,0,',','.') }}</option>
                    @endforeach
                </select>
                <input type="number" name="satuan[${satuanIndex}][jumlah]" placeholder="Jumlah" class="border rounded p-2 w-1/4">
                <input type="number" name="satuan[${satuanIndex}][harga]" placeholder="Harga" class="border rounded p-2 w-1/4">
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        satuanIndex++;
    });
</script>
@endsection
