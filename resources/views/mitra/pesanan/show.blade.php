@extends('layouts.mitra')

@section('title', 'Detail Pesanan')

@section('content')
<div class="p-6 max-w-6xl mx-auto space-y-6">

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-600 text-red-800 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Detail Pesanan #{{ $pesanan->id }}</h1>
        <a href="{{ route('mitra.pesanan.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">← Kembali</a>
    </div>

    {{-- INFORMASI PELANGGAN --}}
    <div class="bg-white p-5 rounded-lg shadow border">
        <h2 class="text-lg font-semibold mb-4">🧍 Informasi Pelanggan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <p><strong>Nama:</strong>
                {{ $pesanan->pelanggan->name ?? $pesanan->pelangganProfile->user->name ?? $pesanan->walkinCustomer->nama ?? '-' }}
            </p>
            <p><strong>Alamat:</strong> {{ $pesanan->pelangganProfile->alamat ?? $pesanan->walkinCustomer->alamat ?? '-' }}</p>
            <p><strong>No. Telepon:</strong> {{ $pesanan->pelangganProfile->no_telepon ?? $pesanan->walkinCustomer->no_tlp ?? '-' }}</p>
        </div>
    </div>

    {{-- DETAIL PESANAN --}}
    <div class="bg-white p-5 rounded-lg shadow border">
        <h2 class="text-lg font-semibold mb-4">📄 Detail Pesanan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <p><strong>Jenis Pesanan:</strong> {{ ucfirst($pesanan->jenis_pesanan) }}</p>
            <p><strong>Tanggal Pesan:</strong> {{ $pesanan->tanggal_pesan }}</p>
            <p><strong>Catatan:</strong> {{ $pesanan->catatan_pesanan ?? '-' }}</p>
            <p>
                <strong>Opsi Jemput:</strong> {{ $pesanan->opsi_jemput }}
                @if($pesanan->jadwal_jemput)
                    — <span class="text-blue-600 font-medium">{{ $pesanan->jadwal_jemput }}</span>
                @endif
            </p>
            <p>
                <strong>Opsi Antar:</strong> {{ $pesanan->opsi_antar }}
                @if($pesanan->jadwal_antar)
                    — <span class="text-green-600 font-medium">{{ $pesanan->jadwal_antar }}</span>
                @endif
            </p>
        </div>
    </div>

    {{-- RINCIAN KILOAN + KONFIRMASI TIMBANGAN --}}
    @if($pesanan->kiloanDetails->count())
        <div class="bg-white p-5 rounded-lg shadow border">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-semibold">⚖️ Rincian Kiloan</h2>
                @php
                    $needTimbangan = $pesanan->kiloanDetails->whereNull('berat_final')->count() > 0;
                @endphp
                @if($needTimbangan)
                    <span class="text-sm text-yellow-700 font-medium">Menunggu konfirmasi timbangan</span>
                @else
                    <span class="text-sm text-green-700 font-medium">Timbangan sudah dikonfirmasi</span>
                @endif
            </div>

            <form id="konfirmasiTimbanganForm" action="{{ route('mitra.pesanan.konfirmasi.timbangan', $pesanan->id) }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="w-full border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border text-left">Layanan</th>
                                <th class="p-2 border text-right">Berat Sementara (kg)</th>
                                <th class="p-2 border text-right">Berat Final (kg)</th>
                                <th class="p-2 border text-right">Harga/kg</th>
                                <th class="p-2 border text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan->kiloanDetails as $k)
                                @php
                                    $originalSubtotal = $k->subtotal ?? ($k->berat_final ? $k->berat_final * $k->harga_per_kg : ($k->berat_sementara ? $k->berat_sementara * $k->harga_per_kg : 0));
                                @endphp
                                <tr data-row-id="{{ $k->id }}">
                                    <td class="p-2 border">
                                        {{ optional($k->layananMitraKiloan)->layananKiloan->nama_paket ?? '—' }}
                                    </td>
                                    <td class="p-2 border text-right">{{ $k->berat_sementara ?? '-' }}</td>
                                    <td class="p-2 border text-right">
                                        @if(is_null($k->berat_final))
                                            <input
                                                type="number"
                                                step="1"
                                                min="1"
                                                name="berat_final[{{ $k->id }}]"
                                                data-harga="{{ $k->harga_per_kg }}"
                                                data-row="{{ $k->id }}"
                                                class="berat-input border rounded p-1 text-right w-28"
                                                placeholder="0.00"
                                            >
                                        @else
                                            <span class="text-right inline-block w-28">{{ $k->berat_final }}</span>
                                        @endif
                                    </td>
                                    <td class="p-2 border text-right">Rp{{ number_format($k->harga_per_kg,0,',','.') }}</td>
                                    <td class="p-2 border text-right">
                                        <span class="subtotal" id="subtotal-{{ $k->id }}" data-original="{{ $originalSubtotal }}">
                                            Rp{{ number_format($originalSubtotal,0,',','.') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="p-2 border text-right font-semibold">Total (perkiraan)</td>
                                <td class="p-2 border text-right font-semibold">
                                    <span id="totalPreview">
                                        Rp{{ number_format($pesanan->kiloanDetails->sum('subtotal') + $pesanan->satuanDetails->sum('subtotal') ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($needTimbangan)
                    <div class="mt-4 flex gap-2">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Konfirmasi Timbangan & Hitung Ulang Tagihan
                        </button>
                        <button type="button" id="previewReset" class="bg-gray-200 px-4 py-2 rounded">Reset Preview</button>
                    </div>
                @endif
            </form>
        </div>
    @endif

    {{-- RINCIAN SATUAN --}}
    @if($pesanan->satuanDetails->count())
        <div class="bg-white p-5 rounded-lg shadow border">
            <h2 class="text-lg font-semibold mb-4">📦 Rincian Satuan</h2>
            <div class="overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border text-left">Layanan</th>
                            <th class="p-2 border text-right">Jumlah</th>
                            <th class="p-2 border text-right">Harga/item</th>
                            <th class="p-2 border text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan->satuanDetails as $s)
                            <tr>
                                <td class="p-2 border">{{ optional($s->layananMitraSatuan)->layananSatuan->nama_layanan ?? '—' }}</td>
                                <td class="p-2 border text-right">{{ $s->jumlah_item }}</td>
                                <td class="p-2 border text-right">Rp{{ number_format($s->harga_per_item,0,',','.') }}</td>
                                <td class="p-2 border text-right">Rp{{ number_format($s->subtotal ?? ($s->jumlah_item * $s->harga_per_item),0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- TAGIHAN --}}
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-5 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-3">💰 Tagihan</h2>
        <p><strong>Total Tagihan:</strong>
            Rp{{ number_format($pesanan->tagihan->total_tagihan ?? ($pesanan->kiloanDetails->sum('subtotal') + $pesanan->satuanDetails->sum('subtotal')),0,',','.') }}
        </p>
        <p><strong>DP Dibayar:</strong> Rp{{ number_format($pesanan->tagihan->dp_dibayar ?? 0,0,',','.') }}</p>
        <p><strong>Sisa Tagihan:</strong> Rp{{ number_format($pesanan->tagihan->sisa_tagihan ?? max(0, ($pesanan->tagihan->total_tagihan ?? 0) - ($pesanan->tagihan->dp_dibayar ?? 0)),0,',','.') }}</p>
        <p><strong>Status Pembayaran:</strong>
            <span class="px-2 py-1 rounded text-white {{ ($pesanan->tagihan->status_pembayaran ?? '') == 'lunas' ? 'bg-green-600' : 'bg-red-500' }}">
                {{ ucfirst(str_replace('_',' ', $pesanan->tagihan->status_pembayaran ?? '-')) }}
            </span>
        </p>
    </div>

    {{-- RIWAYAT TRANSAKSI --}}
    <div class="bg-white p-5 rounded-lg shadow border">
        <h2 class="text-lg font-semibold mb-4">🧾 Riwayat Transaksi</h2>
        @php
            $riwayats = $pesanan->riwayatTransaksi ?? ($pesanan->tagihan->riwayatTransaksi ?? collect());
        @endphp
        <div class="overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Waktu</th>
                        <th class="p-2 border">Nominal</th>
                        <th class="p-2 border">Jenis</th>
                        <th class="p-2 border">Metode</th>
                        <th class="p-2 border">User</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayats as $r)
                        <tr>
                            <td class="p-2 border text-sm">{{ $r->waktu ?? $r->created_at ?? '-' }}</td>
                            <td class="p-2 border text-right">Rp{{ number_format($r->nominal ?? 0,0,',','.') }}</td>
                            <td class="p-2 border">{{ ucfirst($r->jenis_transaksi ?? '-') }}</td>
                            <td class="p-2 border">{{ ucfirst($r->metode_bayar ?? '-') }}</td>
                            <td class="p-2 border">{{ optional($r->user)->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-2 text-center text-gray-500">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- FORM TAMBAH PEMBAYARAN --}}
    @if($pesanan->tagihan && ($pesanan->tagihan->sisa_tagihan ?? 0) > 0)
        <div class="bg-white p-5 rounded-lg shadow border">
            <h2 class="text-lg font-semibold mb-4">➕ Tambah Pembayaran</h2>
            <form action="{{ route('mitra.transaksi.store', $pesanan->tagihan->id) }}" method="POST" class="grid gap-3 md:grid-cols-3">
                @csrf
                <input type="number" name="nominal" class="border rounded p-2 w-full" placeholder="Nominal" required>
                <select name="jenis_transaksi" class="border rounded p-2 w-full">
                    <option value="dp">DP</option>
                    <option value="pelunasan">Pelunasan</option>
                    <option value="pembayaran">Pembayaran</option>
                </select>
                <select name="metode_bayar" class="border rounded p-2 w-full">
                    <option value="transfer">Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="tunai">Tunai</option>
                </select>
                <div class="md:col-span-3">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    @endif

    {{-- TIMELINE STATUS --}}
    <div class="bg-white p-5 rounded-lg shadow border">
        <h2 class="text-lg font-semibold mb-4">📌 Riwayat Status</h2>
        <div class="space-y-4">
            @foreach($pesanan->trackingStatus as $ts)
                <div class="flex items-start gap-3">
                    <div class="w-3 h-3 mt-1 rounded-full {{ $loop->first ? 'bg-blue-600' : 'bg-gray-400' }}"></div>
                    <div>
                        <p class="font-semibold">{{ optional($ts->statusMaster)->nama_status ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $ts->waktu ?? $ts->created_at ?? '-' }} — {{ $ts->pesan ?? '-' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- UPDATE STATUS --}}
    <div class="bg-white p-5 rounded-lg shadow border">
        <h2 class="text-lg font-semibold mb-4">✏️ Update Status</h2>
        <form action="{{ route('mitra.pesanan.update.status', $pesanan->id) }}" method="POST" class="flex gap-2 items-center">
            @csrf
            <select name="status_master_id" class="border rounded p-2">
                @foreach($statusList as $st)
                    <option value="{{ $st->id }}" {{ optional($pesanan->trackingStatus->last())->status_master_id == $st->id ? 'selected' : '' }}>
                        {{ $st->nama_status }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>

</div>

{{-- SCRIPT --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const beratInputs = Array.from(document.querySelectorAll('.berat-input'));
    const formatID = (n) => {
        if (!isFinite(n)) return '0';
        return new Intl.NumberFormat('id-ID').format(Math.round(n));
    };

    function computeRowSubtotal(rowId, inputEl) {
        const harga = parseFloat(inputEl.dataset.harga) || 0;
        const berat = parseFloat(inputEl.value) || 0;
        const subtotal = harga * berat;
        const subtotalEl = document.getElementById('subtotal-' + rowId);
        if (subtotalEl) {
            subtotalEl.textContent = 'Rp' + formatID(subtotal);
            subtotalEl.dataset.current = subtotal;
        }
        return subtotal;
    }

    function computeTotalPreview() {
        let total = 0;
        const subtotalEls = document.querySelectorAll('.subtotal');
        subtotalEls.forEach(function(el){
            const current = parseFloat(el.dataset.current ?? el.getAttribute('data-original')) || 0;
            total += current;
        });
        document.getElementById('totalPreview').textContent = 'Rp' + formatID(total);
    }

    beratInputs.forEach(function(input){
        input.addEventListener('input', function(){
            const rowId = input.dataset.row;
            computeRowSubtotal(rowId, input);
            computeTotalPreview();
        });
        if (input.value) {
            computeRowSubtotal(input.dataset.row, input);
        }
    });

    const resetBtn = document.getElementById('previewReset');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(){
            document.querySelectorAll('.subtotal').forEach(function(el){
                el.textContent = 'Rp' + formatID(el.getAttribute('data-original'));
                el.dataset.current = el.getAttribute('data-original');
            });
            computeTotalPreview();
            beratInputs.forEach(input => { input.value = ''; });
        });
    }
});
</script>
@endpush

@endsection
