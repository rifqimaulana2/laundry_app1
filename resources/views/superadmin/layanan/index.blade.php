@extends('layouts.admin')

@section('title', 'Kelola Layanan')

@section('content')
<div class="container">
    <h1 class="mb-4">Kelola Layanan</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <ul class="nav nav-tabs" id="layananTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="jenis-tab" data-toggle="tab" href="#jenis" role="tab">Jenis Layanan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="kiloan-tab" data-toggle="tab" href="#kiloan" role="tab">Kiloan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="satuan-tab" data-toggle="tab" href="#satuan" role="tab">Satuan</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="layananTabContent">
        {{-- Tab Jenis Layanan --}}
        <div class="tab-pane fade show active" id="jenis" role="tabpanel">
            <form action="{{ route('superadmin.layanan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="jenis_layanan">
                <div class="form-group">
                    <label>Nama Jenis Layanan</label>
                    <input type="text" name="nama_layanan" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success mb-3">Tambah</button>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr><th>Nama</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach ($jenisLayanan as $jenis)
                    <tr>
                        <td>{{ $jenis->nama_layanan }}</td>
                        <td>
                            <form action="{{ route('superadmin.layanan.destroy', [$jenis->id, 'jenis_layanan']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tab Kiloan --}}
        <div class="tab-pane fade" id="kiloan" role="tabpanel">
            <form action="{{ route('superadmin.layanan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="kiloan">
                <div class="form-group">
                    <label>Nama Paket</label>
                    <input type="text" name="nama_paket" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Durasi (Hari)</label>
                    <input type="number" name="durasi_hari" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success mb-3">Tambah</button>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr><th>Nama Paket</th><th>Durasi</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach ($layananKiloan as $kilo)
                    <tr>
                        <td>{{ $kilo->nama_paket }}</td>
                        <td>{{ $kilo->durasi_hari }} hari</td>
                        <td>
                            <form action="{{ route('superadmin.layanan.destroy', [$kilo->id, 'kiloan']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tab Satuan --}}
        <div class="tab-pane fade" id="satuan" role="tabpanel">
            <form action="{{ route('superadmin.layanan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="satuan">
                <div class="form-group">
                    <label>Nama Layanan</label>
                    <input type="text" name="nama_layanan" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success mb-3">Tambah</button>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr><th>Nama</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach ($layananSatuan as $satuan)
                    <tr>
                        <td>{{ $satuan->nama_layanan }}</td>
                        <td>
                            <form action="{{ route('superadmin.layanan.destroy', [$satuan->id, 'satuan']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
