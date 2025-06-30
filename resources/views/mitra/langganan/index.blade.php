@extends('layouts.mitra')

@section('title', 'Status Langganan')

@section('content')
<h2 class="text-xl font-semibold mb-4">Langganan Anda</h2>

@if($langganan)
    <div class="bg-white p-4 rounded shadow">
        <p>Status: <strong>{{ ucfirst($langganan->status) }}</strong></p>
        <p>Berlaku Sampai: <strong>{{ $langganan->berlaku_sampai }}</strong></p>
    </div>
@else
    <p>Belum berlangganan. <a href="#" class="text-blue-600 underline">Klik di sini untuk berlangganan.</a></p>
@endif
@endsection
