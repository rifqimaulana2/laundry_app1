@extends('layouts.pelanggan')

@section('content')
<div class="p-6 max-w-xl mx-auto bg-white rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4">Bayar Tagihan #{{ $tagihan->id }}</h2>

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <p class="mb-2">Jenis Pembayaran:
        <strong>
            {{ $tagihan->dp_dibayar == 0 && $tagihan->tipe_dp_wajib === 'Ya' ? 'DP' : 'Pelunasan' }}
        </strong>
    </p>
    <p class="mb-4">Total yang harus dibayar:
        <strong>
            Rp {{ number_format(
                $tagihan->dp_dibayar > 0 
                    ? $tagihan->sisa_tagihan 
                    : ($tagihan->tipe_dp_wajib === 'Ya' 
                        ? ceil($tagihan->total_tagihan * 0.5) 
                        : $tagihan->total_tagihan
                    ), 
                0, ',', '.') }}
        </strong>
    </p>

    <div class="flex gap-4">
        <button id="pay-button" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Bayar Sekarang
        </button>
        <a href="{{ route('pelanggan.tagihan.show', $tagihan->id) }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
           Kembali
        </a>
    </div>
</div>

{{-- Midtrans Snap.js --}}
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}">
</script>

<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                console.log('Pembayaran sukses:', result);
                window.location.href = '{{ route('pelanggan.tagihan.show', $tagihan->id) }}';
            },
            onPending: function(result) {
                console.log('Pembayaran pending:', result);
                alert("Pembayaran tertunda. Silakan cek status tagihan Anda.");
            },
            onError: function(result) {
                console.log('Pembayaran error:', result);
                alert("Pembayaran gagal. Silakan coba lagi.");
            },
            onClose: function() {
                console.log('Popup ditutup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection
