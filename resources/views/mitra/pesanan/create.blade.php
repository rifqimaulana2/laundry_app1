@extends('layouts.mitra')

@section('title', 'Tambah Pesanan')

@section('content')
<div class="p-6 max-w-6xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Tambah Pesanan</h1>
        <a href="{{ route('mitra.pesanan.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
            Kembali
        </a>
    </div>

    {{-- Form utama --}}
    <form action="{{ route('mitra.pesanan.store') }}" method="POST" class="space-y-6 bg-white rounded-xl shadow-lg p-6">
        @csrf

        {{-- TIPE PELANGGAN --}}
        <div>
            <label class="block font-semibold mb-2">Tipe Pelanggan</label>
            <select name="pelanggan_tipe" id="pelanggan_tipe" class="w-full border rounded-lg p-2">
                <option value="">-- Pilih Tipe Pelanggan --</option>
                <option value="online">Pelanggan Terdaftar</option>
                <option value="walkin">Pelanggan Walk-in</option>
            </select>
        </div>

        {{-- PELANGGAN TERDAFTAR --}}
        <div id="pelangganOnline" class="hidden">
            <label class="block font-semibold mb-2">Pilih Pelanggan Terdaftar</label>
            <select name="user_id" id="user_id" class="w-full border rounded-lg p-2">
                <option value="">-- Pilih pelanggan --</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->profile->nama_lengkap ?? $p->name ?? explode('@',$p->email)[0] }} — {{ $p->email }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Nama didapat dari relasi profile jika tersedia.</p>
        </div>

        {{-- PELANGGAN WALK-IN (ambil dari master walkin_customers) --}}
        <div id="pelangganWalkin" class="hidden">
            <label class="block font-semibold mb-2">Pilih Pelanggan Walk-in</label>
            <select name="walkin_customer_id" id="walkin_customer_id" class="w-full border rounded-lg p-2">
                <option value="">-- Pilih pelanggan walk-in --</option>
                @foreach($walkinCustomers as $w)
                    <option value="{{ $w->id }}">{{ $w->nama }}{{ $w->no_tlp ? ' — '.$w->no_tlp : '' }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Tambah/edit walk-in lewat menu Walk-in Customers.</p>
        </div>

        {{-- JENIS PESANAN --}}
        <div>
            <label class="block font-semibold mb-2">Jenis Pesanan</label>
            <select name="jenis_pesanan" id="jenis_pesanan" class="w-full border rounded-lg p-2" required>
                <option value="">-- Pilih Jenis Pesanan --</option>
                <option value="Kiloan">Kiloan</option>
                <option value="Satuan">Satuan</option>
                <option value="Kiloan + Satuan">Kiloan + Satuan</option>
            </select>
        </div>

        {{-- LAYANAN KILOAN (bisa tambah baris jika butuh, tapi default 1 row) --}}
        <div id="layananKiloanWrapper" class="hidden rounded-lg border p-4 bg-gray-50">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold">Layanan Kiloan</h3>
                <span class="text-xs text-gray-500">Pilih paket (Reguler / Ekspres) — tampil: nama, harga & durasi</span>
            </div>

            <div id="kiloanRows" class="space-y-3">
                <div class="kiloan-row grid grid-cols-12 gap-3 items-end">
                    <div class="col-span-7">
                        <label class="block text-xs text-gray-700 mb-1">Paket</label>
                        <select name="kiloan[0][layanan_id]" class="kiloan-paket w-full border rounded-lg p-2">
                            <option value="">— Pilih paket kiloan —</option>
                            @foreach($layananKiloan as $lk)
                                @php
                                    // nama paket dari relasi (bisa berbeda nama kolom di DB, coba beberapa kemungkinan)
                                    $namaPaket = optional($lk->layananKiloan)->nama_paket
                                                 ?? optional($lk->layananKiloan)->nama_layanan
                                                 ?? ($lk->nama_layanan ?? 'Paket');
                                    $durasi = optional($lk->layananKiloan)->durasi_pengerjaan
                                              ?? optional($lk->layananKiloan)->estimasi_waktu_jam
                                              ?? ($lk->durasi_pengerjaan ?? null);
                                    $satuanDurasi = optional($lk->layananKiloan)->satuan_durasi ?? ($lk->satuan_durasi ?? 'jam');
                                @endphp
                                <option value="{{ $lk->id }}"
                                        data-harga="{{ $lk->harga_per_kg ?? 0 }}"
                                        data-nama="{{ $namaPaket }}"
                                        data-durasi="{{ $durasi }}"
                                        data-satuan="{{ $satuanDurasi }}">
                                    {{ $namaPaket }} — Rp{{ number_format($lk->harga_per_kg ?? 0, 0, ',', '.') }}/kg
                                    @if($durasi) — Durasi: {{ $durasi }} {{ $satuanDurasi }} @endif
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="kiloan[0][harga]" class="kiloan-harga-hidden" value="">
                    </div>

                    <div class="col-span-3">
                        <label class="block text-xs text-gray-700 mb-1">Berat (kg)</label>
                        <input type="number" step="1" min="0" name="kiloan[0][berat]" class="kiloan-berat w-full border rounded-lg p-2" placeholder="0.0">
                    </div>

                    <div class="col-span-2 text-right">
                        <label class="block text-xs text-gray-700 mb-1">Subtotal</label>
                        <div class="rounded-lg border bg-white p-2 text-sm font-semibold" style="min-height:40px;">
                            Rp<span class="kiloan-subtotal">0</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 text-xs text-gray-500">Harga dan durasi diambil dari relasi layanan mitra → master layanan.</div>
        </div>

        {{-- LAYANAN SATUAN (multi item) --}}
        <div id="layananSatuanWrapper" class="hidden rounded-lg border p-4 bg-gray-50">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold">Layanan Satuan</h3>
                <button type="button" id="btnAddSatuan" class="text-sm bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700">+ Tambah Item</button>
            </div>

            <div id="satuanRows" class="space-y-3">
                {{-- default kosong; user bisa tambah baris --}}
            </div>

            <div class="mt-3 text-xs text-gray-500">Pilih layanan satuan — nama, harga & durasi ditampilkan.</div>
        </div>

        {{-- OPSI JEMPUT / ANTAR --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-2">Opsi Jemput</label>
                <select name="opsi_jemput" id="opsi_jemput" class="w-full border rounded-lg p-2">
                    <option value="Tidak">Tidak</option>
                    <option value="Ya">Ya</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-2">Opsi Antar</label>
                <select name="opsi_antar" id="opsi_antar" class="w-full border rounded-lg p-2">
                    <option value="Tidak">Tidak</option>
                    <option value="Ya">Ya</option>
                </select>
            </div>
        </div>

        {{-- JADWAL JIKA ADA ANTAR/JEMPUT --}}
        <div id="jadwalWrapper" class="hidden rounded-lg border p-4 bg-gray-50">
            <h3 class="font-semibold mb-3">Jadwal Jemput / Antar</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium">Tanggal</label>
                    <input type="date" name="jadwal_tanggal" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-xs font-medium">Waktu</label>
                    <input type="time" name="jadwal_waktu" class="w-full border rounded-lg p-2">
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Isikan tanggal & waktu jika jemput/antar diperlukan.</p>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold shadow">
                Simpan Pesanan
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // utility
    const fmt = n => new Intl.NumberFormat('id-ID').format(Math.round(n||0));

    // show/hide pelanggan terdaftar vs walkin
    const pelangganTipe = document.getElementById('pelanggan_tipe');
    const pelangganOnline = document.getElementById('pelangganOnline');
    const pelangganWalkin = document.getElementById('pelangganWalkin');

    pelangganTipe.addEventListener('change', () => {
        pelangganOnline.classList.toggle('hidden', pelangganTipe.value !== 'online');
        pelangganWalkin.classList.toggle('hidden', pelangganTipe.value !== 'walkin');
    });

    // jenis pesanan: toggle kiloan / satuan
    const jenisPesanan = document.getElementById('jenis_pesanan');
    const kiloanWrapper = document.getElementById('layananKiloanWrapper');
    const satuanWrapper = document.getElementById('layananSatuanWrapper');

    function applyJenis() {
        const v = jenisPesanan.value;
        kiloanWrapper.classList.toggle('hidden', !v.includes('Kiloan'));
        satuanWrapper.classList.toggle('hidden', !v.includes('Satuan'));
    }
    jenisPesanan.addEventListener('change', applyJenis);
    applyJenis();

    // jadwal antar/jemput
    const opsiJemput = document.getElementById('opsi_jemput');
    const opsiAntar = document.getElementById('opsi_antar');
    const jadwalWrapper = document.getElementById('jadwalWrapper');

    function toggleJadwal() {
        const show = (opsiJemput.value === 'Ya') || (opsiAntar.value === 'Ya');
        jadwalWrapper.classList.toggle('hidden', !show);
    }
    opsiJemput.addEventListener('change', toggleJadwal);
    opsiAntar.addEventListener('change', toggleJadwal);
    toggleJadwal();

    // KILOAN: live subtotal per row
    function recalcKiloanRow(row) {
        const sel = row.querySelector('.kiloan-paket');
        const beratEl = row.querySelector('.kiloan-berat');
        const subtotalEl = row.querySelector('.kiloan-subtotal');
        const hargaHidden = row.querySelector('.kiloan-harga-hidden');

        const harga = parseFloat(sel.selectedOptions[0]?.dataset.harga || 0);
        const berat = parseFloat(beratEl.value || 0);
        const sub = Math.max(0, harga * berat);
        subtotalEl.textContent = fmt(sub);
        if (hargaHidden) hargaHidden.value = harga || '';
    }

    document.querySelectorAll('#kiloanRows .kiloan-row').forEach(r => {
        r.querySelector('.kiloan-paket').addEventListener('change', () => recalcKiloanRow(r));
        r.querySelector('.kiloan-berat').addEventListener('input', () => recalcKiloanRow(r));
    });

    // SATUAN: add/remove rows
    const btnAddSatuan = document.getElementById('btnAddSatuan');
    const satuanRows = document.getElementById('satuanRows');
    let satuanIndex = 0;

    btnAddSatuan && btnAddSatuan.addEventListener('click', function () {
        const tpl = document.createElement('div');
        tpl.className = 'satuan-row grid grid-cols-12 gap-3 items-end';
        tpl.innerHTML = `
            <div class="col-span-6">
                <label class="block text-xs text-gray-700 mb-1">Layanan</label>
                <select name="satuan[${satuanIndex}][layanan_id]" class="satuan-paket w-full border rounded-lg p-2">
                    <option value="">— Pilih layanan satuan —</option>
                    @foreach($layananSatuan as $ls)
                        @php
                            $namaSatuan = optional($ls->layananSatuan)->nama_layanan
                                         ?? ($ls->nama_layanan ?? 'Layanan');
                            $durasiS = optional($ls->layananSatuan)->durasi_pengerjaan ?? ($ls->durasi_pengerjaan ?? null);
                            $satuanDur = optional($ls->layananSatuan)->satuan_durasi ?? ($ls->satuan_durasi ?? 'hari');
                        @endphp
                        <option value="{{ $ls->id }}" data-harga="{{ $ls->harga_per_item ?? 0 }}" data-durasi="{{ $durasiS }}" data-satuan="{{ $satuanDur }}">
                            {{ $namaSatuan }} — Rp{{ number_format($ls->harga_per_item ?? 0, 0, ',', '.') }}
                            @if($durasiS) — Durasi: {{ $durasiS }} {{ $satuanDur }} @endif
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="satuan[${satuanIndex}][harga]" class="satuan-harga-hidden">
            </div>
            <div class="col-span-3">
                <label class="block text-xs text-gray-700 mb-1">Jumlah</label>
                <input type="number" min="0" name="satuan[${satuanIndex}][jumlah]" class="satuan-qty w-full border rounded-lg p-2" placeholder="0">
            </div>
            <div class="col-span-2 text-right">
                <label class="block text-xs text-gray-700 mb-1">Subtotal</label>
                <div class="rounded-lg border bg-white p-2 text-sm font-semibold">Rp<span class="satuan-sub">0</span></div>
            </div>
            <div class="col-span-1 text-right">
                <button type="button" class="remove-satuan text-sm rounded-lg border px-3 py-1 hover:bg-gray-100">Hapus</button>
            </div>
        `;
        satuanRows.appendChild(tpl);

        const sel = tpl.querySelector('.satuan-paket');
        const qty = tpl.querySelector('.satuan-qty');
        const hargaHidden = tpl.querySelector('.satuan-harga-hidden');
        const subEl = tpl.querySelector('.satuan-sub');
        const rem = tpl.querySelector('.remove-satuan');

        function recalcSatuan() {
            const harga = parseFloat(sel.selectedOptions[0]?.dataset.harga || 0);
            const jumlah = parseFloat(qty.value || 0);
            const sub = Math.max(0, harga * jumlah);
            subEl.textContent = fmt(sub);
            hargaHidden.value = harga || '';
        }

        sel.addEventListener('change', recalcSatuan);
        qty.addEventListener('input', recalcSatuan);
        rem.addEventListener('click', () => {
            tpl.remove();
        });

        satuanIndex++;
    });

    // initial compute for kiloan row(s)
    document.querySelectorAll('#kiloanRows .kiloan-row').forEach(r => recalcKiloanRow(r));
});
</script>
@endsection
