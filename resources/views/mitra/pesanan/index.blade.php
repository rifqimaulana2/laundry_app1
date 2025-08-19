@extends('layouts.mitra')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <h1 class="text-3xl font-bold text-gray-800">📋 Daftar Pesana</h1>
        <a href="{{ route('mitra.pesanan.create') }}"
           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow text-sm font-medium transition">
            ➕ Tambah Pesanan
        </a>
    </div>

    {{-- Alerts --}}
    @foreach (['success'=>'green','error'=>'red'] as $k=>$c)
        @if(session($k))
            <div class="p-4 bg-{{ $c }}-50 border-l-4 border-{{ $c }}-500 text-{{ $c }}-700 rounded-lg shadow-sm">
                {{ session($k) }}
            </div>
        @endif
    @endforeach

    {{-- Filter --}}
    <form method="GET" class="grid md:grid-cols-4 gap-3 bg-white p-4 rounded-lg shadow border border-gray-100">
        <input name="q" value="{{ request('q') }}" placeholder="🔍 Cari nama/telepon/alamat/kode"
               class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
        <select name="jenis" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">📦 Semua jenis</option>
            @foreach (['Kiloan','Satuan','Kiloan + Satuan'] as $jp)
                <option value="{{ $jp }}" @selected(request('jenis')===$jp)>{{ $jp }}</option>
            @endforeach
        </select>
        <select name="jemput" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">🚚 Jemput: semua</option>
            <option value="Ya" @selected(request('jemput')==='Ya')>Ya</option>
            <option value="Tidak" @selected(request('jemput')==='Tidak')>Tidak</option>
        </select>
        <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-3 py-2 shadow transition">
            Filter
        </button>
    </form>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-100">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Pelanggan</th>
                    <th class="px-4 py-3">Telepon</th>
                    <th class="px-4 py-3">Alamat</th>
                    <th class="px-4 py-3">Jenis</th>
                    <th class="px-4 py-3">Jemput</th>
                    <th class="px-4 py-3">Antar</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pesanans as $pesanan)
                    @php
                        $lastStatus = $pesanan->trackingStatus->sortBy('waktu')->last();
                        $statusNama = $lastStatus && $lastStatus->statusMaster
                            ? strtolower(str_replace('_',' ', $lastStatus->statusMaster->nama_status))
                            : 'belum ada status';
                        $badgeClass = $statusMap[$statusNama]['color'] ?? 'bg-gray-200 text-gray-700';
                    @endphp

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}</td>
                        <td class="px-4 py-3 font-medium">{{ $pesanan->nama_pelanggan }}</td>
                        <td class="px-4 py-3 text-center">{{ $pesanan->telepon_pelanggan }}</td>
                        <td class="px-4 py-3">{{ $pesanan->alamat_pelanggan }}</td>
                        <td class="px-4 py-3">{{ $pesanan->jenis_pesanan }}</td>

                        {{-- Jemput --}}
                        <td class="px-4 py-3 text-sm">
                            @if($pesanan->opsi_jemput === 'Ya')
                                <span class="font-medium text-green-600">Ya</span>
                                <div class="text-xs text-gray-500">
                                    {{ $pesanan->jadwal_jemput ? \Carbon\Carbon::parse($pesanan->jadwal_jemput)->format('d M Y H:i') : 'Belum dijadwalkan' }}
                                </div>
                            @else
                                <span class="text-gray-400">Tidak</span>
                            @endif
                        </td>

                        {{-- Antar --}}
                        <td class="px-4 py-3 text-sm">
                            @if($pesanan->opsi_antar === 'Ya')
                                <span class="font-medium text-green-600">Ya</span>
                                <div class="text-xs text-gray-500">
                                    {{ $pesanan->jadwal_antar ? \Carbon\Carbon::parse($pesanan->jadwal_antar)->format('d M Y H:i') : 'Belum dijadwalkan' }}
                                </div>
                            @else
                                <span class="text-gray-400">Tidak</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                {{ ucfirst($statusNama) }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-3 space-y-2">
                            <a href="{{ route('mitra.pesanan.show', $pesanan->id) }}"
                               class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg text-xs transition">
                                Detail
                            </a>
                            <form action="{{ route('mitra.pesanan.updateStatus', $pesanan->id) }}" method="POST" class="flex gap-1">
                                @csrf
                                <select name="status_master_id" class="border border-gray-300 rounded-lg px-2 py-1 text-xs flex-1">
                                    <option value="">-- Ubah Status --</option>
                                    @foreach($statusMap as $statusNamaOpt => $data)
                                        <option value="{{ $data['id'] }}">{{ ucfirst($statusNamaOpt) }}</option>
                                    @endforeach
                                </select>
                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg text-xs">OK</button>
                            </form>
                            <form action="{{ route('mitra.pesanan.destroy', $pesanan->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                            Belum ada pesanan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pt-4">
        {{ $pesanans->links() }}
    </div>
</div>
@endsection
