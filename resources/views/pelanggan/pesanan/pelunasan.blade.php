@extends('layouts.pelanggan')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-2xl shadow-xl space-y-6">
        <h1 class="text-3xl font-bold text-gray-800">Lunasi Pesanan #{{ $tagihan->pesanan_id }}</h1>

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div><span class="font-semibold">Total Tagihan:</span> Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</div>
            <div><span class="font-semibold">Sisa Tagihan:</span> Rp {{ number_format($tagihan->sisa_tagihan, 0, ',', '.') }}</div>
            <div><span class="font-semibold">DP Dibayar:</span> Rp {{ number_format($tagihan->dp_dibayar, 0, ',', '.') }}</div>
        </div>

        <form id="payment-form" method="POST" action="javascript:void(0)">
            <input type="hidden" name="result_type" id="result-type" value="">
            <input type="hidden" name="result_data" id="result-data" value="">
            <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function () {
                    snap.pay('{{ $snapToken }}', {
                        onSuccess: function(result) {
                            document.getElementById('result-type').value = 'success';
                            document.getElementById('result-data').value = JSON.stringify(result);
                            document.getElementById('payment-form').submit();
                        },
                        onPending: function(result) {
                            document.getElementById('result-type').value = 'pending';
                            document.getElementById('result-data').value = JSON.stringify(result);
                            document.getElementById('payment-form').submit();
                        },
                        onError: function(result) {
                            document.getElementById('result-type').value = 'error';
                            document.getElementById('result-data').value = JSON.stringify(result);
                            document.getElementById('payment-form').submit();
                        }
                    });
                });
            </script>
            <button type="submit" class="hidden">Submit</button>
        </form>
    </div>
</div>
@endsection