@extends('layouts.mitra')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full bg-white rounded-3xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Karyawan</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('mitra.employee.update', ['employee' => $employee->id]) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Nama Karyawan</label>
                    <input type="text" value="{{ $employee->user->name }}" class="w-full rounded-lg border-gray-300 text-gray-800 py-2 px-3 bg-gray-100 cursor-not-allowed" disabled>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                    <input type="text" value="{{ $employee->user->email }}" class="w-full rounded-lg border-gray-300 text-gray-800 py-2 px-3 bg-gray-100 cursor-not-allowed" disabled>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">No Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $employee->no_telepon) }}" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 text-gray-800 py-2 px-3" required>
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">Simpan</button>
            </form>
        </div>
    </div>
@endsection
