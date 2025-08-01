<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\Pesanan;
use App\Models\PesananDetailKiloan;
use App\Models\PesananDetailSatuan;
use App\Models\Tagihan;
use App\Models\RiwayatTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:pelanggan');
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())->with(['mitra', 'tagihan'])->get();
        return view('pelanggan.pesanan.index', compact('pesanans'));
    }

    public function create(Mitra $mitra)
    {
        $mitra->load(['layananMitraKiloan.layananKiloan', 'layananMitraSatuan.layananSatuan']);
        return view('pelanggan.pesanan.create', compact('mitra'));
    }

    public function store(Request $request, Mitra $mitra)
    {
        \Log::info('Data yang diterima: ', $request->all());

        $request->validate([
            'jenis_layanan' => 'required|array|min:1',
            'jenis_layanan.*' => 'in:Kiloan Reguler,Kiloan Ekspres,Satuan',
            'catatan_pesanan' => 'nullable|string',
            'tipe_dp_wajib' => 'required|in:Ya,Tidak',
            'tipe_bisa_lunas' => 'required|in:Ya,Tidak',
            'tanggal_pesan' => 'required|date|after_or_equal:today',
            'opsi_jemput' => 'required|in:Ya,Tidak',
            'jadwal_jemput' => 'nullable|date|after_or_equal:today',
            'opsi_antar' => 'required|in:Ya,Tidak',
            'jadwal_antar' => 'nullable|date|after_or_equal:today',
            'catatan_pengiriman' => 'nullable|string',
            'layanan_mitra_kiloan_id' => 'required_if:jenis_layanan,Kiloan Reguler,Kiloan Ekspres|exists:layanan_mitra_kiloan,id',
            'berat_sementara' => 'required_if:jenis_layanan,Kiloan Reguler,Kiloan Ekspres|integer|min:1',
            'satuan' => 'nullable|array',
            'satuan.*.layanan_mitra_satuan_id' => 'required_with:satuan|exists:layanan_mitra_satuan,id',
            'satuan.*.jumlah_item' => 'required_with:satuan|integer|min:1',
        ]);

        $layananDipilih = $request->input('jenis_layanan');
        sort($layananDipilih);

        if (in_array('Kiloan Ekspres', $layananDipilih) && count($layananDipilih) > 1) {
            return back()->withInput()->with('error', 'Kiloan Ekspres tidak dapat digabung dengan layanan lain.');
        }

        $jenisPesanan = $this->determineJenisPesanan($layananDipilih);

        $currentDate = Carbon::now();
        if ($request->opsi_jemput === 'Ya' && $request->filled('jadwal_jemput')) {
            $jadwalJemput = Carbon::parse($request->jadwal_jemput);
            if ($jadwalJemput->lessThan($currentDate)) {
                return back()->withInput()->with('error', 'Jadwal jemput tidak boleh di masa lalu.');
            }
            $hari = $jadwalJemput->locale('id')->isoFormat('dddd');
            $jam = $jadwalJemput->format('H:i');
            $mitra->load('jamOperasionals');
            $jamOperasional = $mitra->jamOperasionals->firstWhere('hari_buka', $hari);
            if (!$jamOperasional || $jam < $jamOperasional->jam_buka || $jam > $jamOperasional->jam_tutup) {
                return back()->withInput()->with('error', 'Jadwal jemput berada di luar jam operasional mitra.');
            }
        }

        if ($request->opsi_antar === 'Ya' && $request->filled('jadwal_antar')) {
            $jadwalAntar = Carbon::parse($request->jadwal_antar);
            if ($jadwalAntar->lessThan($currentDate)) {
                return back()->withInput()->with('error', 'Jadwal antar tidak boleh di masa lalu.');
            }
        }

        try {
            $pesanan = Pesanan::create([
                'user_id' => auth()->id(),
                'mitra_id' => $mitra->id,
                'jenis_pesanan' => $jenisPesanan,
                'catatan_pesanan' => $request->catatan_pesanan,
                'tipe_dp_wajib' => $request->tipe_dp_wajib,
                'tipe_bisa_lunas' => $request->tipe_bisa_lunas,
                'tanggal_pesan' => $request->tanggal_pesan,
                'opsi_jemput' => $request->opsi_jemput,
                'jadwal_jemput' => $request->jadwal_jemput,
                'opsi_antar' => $request->opsi_antar,
                'jadwal_antar' => $request->jadwal_antar,
                'catatan_pengiriman' => $request->catatan_pengiriman,
            ]);

            $totalKiloan = 0;
            if (in_array('Kiloan Reguler', $layananDipilih) || in_array('Kiloan Ekspres', $layananDipilih)) {
                $layananMitraKiloan = $mitra->layananMitraKiloan()->find($request->layanan_mitra_kiloan_id);
                if ($layananMitraKiloan) {
                    $hargaPerKg = $layananMitraKiloan->harga_per_kg ?? 0;
                    $beratSementara = $request->berat_sementara;
                    $subtotal = $beratSementara * $hargaPerKg;
                    PesananDetailKiloan::create([
                        'pesanan_id' => $pesanan->id,
                        'layanan_mitra_kiloan_id' => $request->layanan_mitra_kiloan_id,
                        'berat_sementara' => $beratSementara,
                        'harga_per_kg' => $hargaPerKg,
                        'subtotal' => $subtotal,
                    ]);
                    $totalKiloan += $subtotal;
                }
            }

            $totalSatuan = 0;
            if ($request->filled('satuan')) {
                foreach ($request->satuan as $index => $satuan) {
                    $layananMitraSatuan = $mitra->layananMitraSatuan()->find($satuan['layanan_mitra_satuan_id']);
                    if ($layananMitraSatuan) {
                        $hargaPerItem = $layananMitraSatuan->harga_per_item ?? 0;
                        $subtotal = $satuan['jumlah_item'] * $hargaPerItem;
                        PesananDetailSatuan::create([
                            'pesanan_id' => $pesanan->id,
                            'layanan_mitra_satuan_id' => $satuan['layanan_mitra_satuan_id'],
                            'jumlah_item' => $satuan['jumlah_item'],
                            'harga_per_item' => $hargaPerItem,
                            'subtotal' => $subtotal,
                        ]);
                        $totalSatuan += $subtotal;
                    }
                }
            }

            $totalTagihan = $totalKiloan + $totalSatuan;
            $dpWajib = $request->tipe_dp_wajib === 'Ya' ? ($totalTagihan * 0.5) : 0;
            $dpDibayar = 0;
            $statusPembayaran = $dpWajib > 0 ? 'belum lunas' : 'lunas';
            $sisaTagihan = $totalTagihan - $dpDibayar;

            $tagihan = Tagihan::create([
                'pesanan_id' => $pesanan->id,
                'total_tagihan' => $totalTagihan,
                'dp_dibayar' => $dpDibayar,
                'sisa_tagihan' => $sisaTagihan,
                'metode_bayar' => 'midtrans',
                'status_pembayaran' => $statusPembayaran,
                'jatuh_tempo_pelunasan' => $dpWajib > 0 ? Carbon::now()->addDays(7) : null,
                'waktu_bayar_dp' => null,
            ]);

            if ($dpWajib > 0) {
                return redirect()->route('pelanggan.tagihan.bayar', $tagihan->id)->with('info', 'Pesanan berhasil dibuat. Silakan bayar DP sebesar Rp ' . number_format($dpWajib, 0, ',', '.') . '.');
            }

            return redirect()->route('pelanggan.pesanan.index')->with('success', 'Pesanan berhasil dibuat. Pembayaran langsung lunas.');
        } catch (\Exception $e) {
            \Log::error('Error membuat pesanan: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan pesanan. Periksa log untuk detail.');
        }
    }

    public function show(Pesanan $pesanan)
    {
        $this->authorize('view', $pesanan);
        $pesanan->load(['detailsKiloan.layananMitraKiloan.layananKiloan', 'detailsSatuan.layananMitraSatuan.layananSatuan', 'mitra', 'tagihan']);
        return view('pelanggan.pesanan.show', compact('pesanan'));
    }

    public function konfirmasiTimbangan(Request $request, Pesanan $pesanan)
    {
        $this->authorize('update', $pesanan);
        $request->validate([
            'berat_final' => 'required|numeric|min:0.1',
        ]);

        $detailKiloan = $pesanan->detailsKiloan()->first();
        if ($detailKiloan) {
            $detailKiloan->update([
                'berat_final' => $request->berat_final,
                'subtotal' => $request->berat_final * $detailKiloan->harga_per_kg,
            ]);

            $tagihan = $pesanan->tagihan;
            $kiloanSubtotal = $detailKiloan->subtotal;
            $satuanTotal = $tagihan->total_tagihan - ($detailKiloan->berat_sementara * $detailKiloan->harga_per_kg);
            $newTotalTagihan = $kiloanSubtotal + $satuanTotal;

            $tagihan->update([
                'total_tagihan' => $newTotalTagihan,
                'sisa_tagihan' => $newTotalTagihan - $tagihan->dp_dibayar,
            ]);

            return redirect()->route('mitra.pesanan.show', $pesanan)->with('success', 'Timbangan berhasil dikonfirmasi.');
        }

        return back()->with('error', 'Tidak ada detail kiloan untuk pesanan ini.');
    }

    public function bayarDp(Request $request, Tagihan $tagihan)
    {
        $this->authorize('update', $tagihan->pesanan);
        $pesanan = $tagihan->pesanan;

        if ($tagihan->dp_dibayar > 0) {
            return back()->with('error', 'DP sudah dibayar.');
        }

        $dpWajib = $tagihan->total_tagihan * 0.5;
        $params = [
            'transaction_details' => [
                'order_id' => 'DP-' . $tagihan->pesanan_id . '-' . time(),
                'gross_amount' => $dpWajib,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone ?? '',
            ],
            'callbacks' => [
                'finish' => route('pelanggan.pesanan.show', $pesanan->id),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('pelanggan.pesanan.bayar-dp', compact('snapToken', 'dpWajib', 'tagihan'));
    }

    public function pelunasan(Request $request, Pesanan $pesanan)
    {
        $this->authorize('update', $pesanan);
        $tagihan = $pesanan->tagihan;

        if ($tagihan->sisa_tagihan <= 0) {
            return back()->with('error', 'Tidak ada sisa tagihan untuk dilunasi.');
        }

        if ($tagihan->dp_dibayar == 0 && $pesanan->tipe_dp_wajib === 'Ya') {
            return back()->with('error', 'Silakan bayar DP terlebih dahulu.');
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'PELUNASAN-' . $pesanan->id . '-' . time(),
                'gross_amount' => $tagihan->sisa_tagihan,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone ?? '',
            ],
            'callbacks' => [
                'finish' => route('pelanggan.pesanan.show', $pesanan->id),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('pelanggan.pesanan.pelunasan', compact('snapToken', 'tagihan'));
    }

    public function callback(Request $request, Tagihan $tagihan)
    {
        $notif = new \Midtrans\Notification();
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $grossAmount = $notif->gross_amount;
        $transactionTime = $notif->transaction_time;
        $transactionStatus = $notif->transaction_status;

        $pesanan = $tagihan->pesanan;

        if ($transactionStatus == 'capture') {
            if ($orderId && strpos($orderId, 'DP-') === 0) {
                $tagihan->update([
                    'dp_dibayar' => $grossAmount,
                    'sisa_tagihan' => $tagihan->total_tagihan - $grossAmount,
                    'status_pembayaran' => $grossAmount >= $tagihan->total_tagihan ? 'lunas' : 'belum lunas',
                    'waktu_bayar_dp' => Carbon::parse($transactionTime),
                    'metode_bayar' => $type,
                ]);

                RiwayatTransaksi::create([
                    'pesanan_id' => $pesanan->id,
                    'user_id' => auth()->id(),
                    'nominal' => $grossAmount,
                    'jenis_transaksi' => 'dp',
                    'metode_bayar' => $type,
                    'waktu' => Carbon::parse($transactionTime),
                ]);
            } elseif ($orderId && strpos($orderId, 'PELUNASAN-') === 0) {
                $tagihan->update([
                    'dp_dibayar' => $tagihan->dp_dibayar + $grossAmount,
                    'sisa_tagihan' => max(0, $tagihan->sisa_tagihan - $grossAmount),
                    'status_pembayaran' => $tagihan->sisa_tagihan - $grossAmount <= 0 ? 'lunas' : 'belum lunas',
                    'waktu_pelunasan' => Carbon::parse($transactionTime),
                    'metode_bayar' => $type,
                ]);

                RiwayatTransaksi::create([
                    'pesanan_id' => $pesanan->id,
                    'user_id' => auth()->id(),
                    'nominal' => $grossAmount,
                    'jenis_transaksi' => 'pelunasan',
                    'metode_bayar' => $type,
                    'waktu' => Carbon::parse($transactionTime),
                ]);
            }
        }

        return redirect()->route('pelanggan.pesanan.show', $pesanan->id)->with('success', 'Pembayaran berhasil diproses.');
    }

    private function determineJenisPesanan($layananDipilih)
    {
        if (in_array('Kiloan Reguler', $layananDipilih) && in_array('Satuan', $layananDipilih)) {
            return 'Kiloan + Satuan';
        } elseif (in_array('Kiloan Reguler', $layananDipilih)) {
            return 'Kiloan';
        } elseif (in_array('Kiloan Ekspres', $layananDipilih)) {
            return 'Kiloan';
        } elseif (in_array('Satuan', $layananDipilih)) {
            return 'Satuan';
        }
        return 'gabungan';
    }
}