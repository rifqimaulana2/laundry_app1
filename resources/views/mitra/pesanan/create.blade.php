@extends('layouts.mitra')

@section('title', 'Tambah Pesanan')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-indigo-600">
            <h1 class="text-white text-2xl font-bold">Tambah Pesanan Baru</h1>
            <p class="text-white/80 text-sm mt-1">Buat pesanan untuk pelanggan online atau walk-in</p>
        </div>

        <form action="{{ route('mitra.pesanan.store') }}" method="POST" class="p-6 space-y-8">
            @csrf

            {{-- Error block --}}
            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                    <div class="font-semibold mb-1">Periksa kembali isian Anda:</div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Tipe Pelanggan --}}
            <section class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-800">Data Pelanggan</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Pilih tipe pelanggan --}}
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Pelanggan</label>
                        <select name="pelanggan_tipe" id="pelanggan_tipe" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih --</option>
                            <option value="online" {{ old('pelanggan_tipe')==='online'?'selected':'' }}>Pelanggan Online</option>
                            <option value="walkin" {{ old('pelanggan_tipe')==='walkin'?'selected':'' }}>Pelanggan Walk-In Baru</option>
                            <option value="walkin_existing" {{ old('pelanggan_tipe')==='walkin_existing'?'selected':'' }}>Pelanggan Walk-In Terdaftar</option>
                        </select>
                    </div>

                    {{-- Pelanggan Online --}}
                    <div id="pelanggan_online" class="hidden md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Pelanggan Online</label>
                        <select name="user_id" id="select_online" class="w-full rounded-xl border-gray-300">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $pel)
                                <option value="{{ $pel->id }}" {{ old('user_id')==$pel->id?'selected':'' }}>
                                    {{ $pel->profile->nama ?? $pel->name }} — {{ $pel->profile->no_telepon ?? $pel->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Walk-in baru --}}
                    <div id="pelanggan_walkin" class="hidden md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <input type="text" name="alamat" value="{{ old('alamat') }}" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- Walk-in existing --}}
                    <div id="pelanggan_walkin_existing" class="hidden md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Pelanggan Walk-In</label>
                        <select name="walkin_customer_id" id="select_walkin" class="w-full rounded-xl border-gray-300">
                            <option value="">-- Pilih --</option>
                            @foreach($walkinCustomers as $wc)
                                <option value="{{ $wc->id }}" {{ old('walkin_customer_id')==$wc->id?'selected':'' }}>
                                    {{ $wc->name }} — {{ $wc->no_telepon }} — {{ $wc->alamat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            {{-- Jenis & Pengiriman --}}
            <section class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-800">Jenis Pesanan & Pengiriman</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pesanan</label>
                        <select name="jenis_pesanan" id="jenis_pesanan" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="Kiloan" {{ old('jenis_pesanan')==='Kiloan'?'selected':'' }}>Kiloan</option>
                            <option value="Satuan" {{ old('jenis_pesanan')==='Satuan'?'selected':'' }}>Satuan</option>
                            <option value="Kiloan + Satuan" {{ old('jenis_pesanan')==='Kiloan + Satuan'?'selected':'' }}>Kiloan + Satuan</option>
                        </select>
                    </div>

                    @if($layananJemputAktif)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Opsi Jemput</label>
                            <select name="opsi_jemput" id="opsi_jemput" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="Tidak" {{ old('opsi_jemput','Tidak')==='Tidak'?'selected':'' }}>Tidak</option>
                                <option value="Ya" {{ old('opsi_jemput')==='Ya'?'selected':'' }}>Ya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Jemput</label>
                            <input type="datetime-local" name="jadwal_jemput" value="{{ old('jadwal_jemput') }}" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    @endif

                    @if($layananAntarAktif)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Opsi Antar</label>
                            <select name="opsi_antar" id="opsi_antar" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="Tidak" {{ old('opsi_antar','Tidak')==='Tidak'?'selected':'' }}>Tidak</option>
                                <option value="Ya" {{ old('opsi_antar')==='Ya'?'selected':'' }}>Ya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Antar</label>
                            <input type="datetime-local" name="jadwal_antar" value="{{ old('jadwal_antar') }}" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Pesanan</label>
                    <textarea name="catatan_pesanan" rows="3" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('catatan_pesanan') }}</textarea>
                </div>
            </section>

            {{-- Layanan Kiloan --}}
            <section id="kiloan_section" class="space-y-3">
                <h2 class="text-lg font-semibold text-gray-800">Pilih Layanan Kiloan</h2>
                @forelse($layananKiloan as $lk)
                    @php
                        $namaPaket = $lk->layananKiloan->nama_paket ?? ($lk->layananKiloan->nama_layanan ?? 'Paket Kiloan');
                        $tipe      = $lk->layananKiloan->tipe ?? (stripos($namaPaket,'ekspres')!==false?'Ekspres':'Reguler');
                        $checked   = old('kiloan_selected') == $lk->id ? 'checked' : '';
                    @endphp
                    <label class="flex items-center justify-between p-4 border rounded-2xl hover:bg-blue-50 transition">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="kiloan_selected" value="{{ $lk->id }}" data-tipe="{{ $tipe }}" class="h-5 w-5 text-blue-600" {{ $checked }}>
                            <div>
                                <div class="font-semibold">{{ $namaPaket }} <span class="ml-2 text-xs border px-2 rounded">{{ $tipe }}</span></div>
                                <div class="text-sm text-gray-500">Rp {{ number_format($lk->harga_per_kg,0,',','.') }}/kg • {{ $lk->durasi_hari }} hari</div>
                            </div>
                        </div>
                        <div>
                            <input type="number" name="kiloan[{{ $lk->id }}][berat]" value="{{ old('kiloan.'.$lk->id.'.berat') }}" min="1" step="0.1" placeholder="Kg" class="w-24 rounded-xl border-gray-300 text-center">
                            <input type="hidden" name="kiloan[{{ $lk->id }}][harga]" value="{{ $lk->harga_per_kg }}">
                        </div>
                    </label>
                @empty
                    <div class="text-sm text-gray-500">Belum ada layanan kiloan pada mitra ini.</div>
                @endforelse
            </section>

            {{-- Layanan Satuan --}}
            <section id="satuan_section" class="space-y-3">
                <h2 class="text-lg font-semibold text-gray-800">Pilih Layanan Satuan</h2>
                @forelse($layananSatuan as $ls)
                    @php
                        $namaSatuan = $ls->layananSatuan->nama_layanan ?? 'Item Satuan';
                    @endphp
                    <label class="flex items-center justify-between p-4 border rounded-2xl hover:bg-blue-50 transition">
                        <div>
                            <div class="font-semibold">{{ $namaSatuan }}</div>
                            <div class="text-sm text-gray-500">Rp {{ number_format($ls->harga_per_item,0,',','.') }} • {{ $ls->durasi_hari }} hari</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="satuan[{{ $ls->id }}][layanan_id]" value="{{ $ls->id }}" {{ old('satuan.'.$ls->id.'.layanan_id') ? 'checked' : '' }}>
                            <input type="number" name="satuan[{{ $ls->id }}][jumlah]" value="{{ old('satuan.'.$ls->id.'.jumlah') }}" min="1" class="w-24 rounded-xl border-gray-300 text-center" placeholder="Jumlah">
                            <input type="hidden" name="satuan[{{ $ls->id }}][harga]" value="{{ $ls->harga_per_item }}">
                        </div>
                    </label>
                @empty
                    <div class="text-sm text-gray-500">Belum ada layanan satuan pada mitra ini.</div>
                @endforelse
            </section>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t">
                <a href="{{ route('mitra.pesanan.index') }}" class="px-5 py-2 rounded-xl border hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow">
                    Simpan Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tom Select --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>
(function() {
    const tipeSelect = document.getElementById('pelanggan_tipe');
    const onlineWrap = document.getElementById('pelanggan_online');
    const walkinWrap = document.getElementById('pelanggan_walkin');
    const walkinExist = document.getElementById('pelanggan_walkin_existing');

    function togglePelanggan() {
        onlineWrap.classList.add('hidden');
        walkinWrap.classList.add('hidden');
        walkinExist.classList.add('hidden');
        if (tipeSelect.value === 'online') onlineWrap.classList.remove('hidden');
        if (tipeSelect.value === 'walkin') walkinWrap.classList.remove('hidden');
        if (tipeSelect.value === 'walkin_existing') walkinExist.classList.remove('hidden');
    }

    togglePelanggan();
    tipeSelect.addEventListener('change', togglePelanggan);

    // Searchable select
    new TomSelect("#select_online", { create: false, sortField: { field: "text", direction: "asc" } });
    new TomSelect("#select_walkin", { create: false, sortField: { field: "text", direction: "asc" } });
})();
</script>
@endsection
