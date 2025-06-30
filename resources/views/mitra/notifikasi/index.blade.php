@extends('layouts.mitra')

@section('title', 'Notifikasi')

@section('content')
<h2 class="text-xl font-semibold mb-4">Notifikasi Masuk</h2>

<ul class="space-y-2">
    @forelse($notifikasi as $n)
        <li class="bg-white p-4 rounded shadow">
            <p>{{ $n->pesan }}</p>
            <p class="text-xs text-gray-500">{{ $n->created_at->diffForHumans() }}</p>
        </li>
    @empty
        <li>Tidak ada notifikasi.</li>
    @endforelse
</ul>
@endsection
