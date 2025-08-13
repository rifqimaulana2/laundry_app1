<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\Pesanan;
use App\Models\PesananDetailKiloan;
use App\Models\PesananDetailSatuan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:pelanggan');
    }

    public function index()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())
            ->with(['mitra', 'tagihan', 'kiloanDetails', 'satuanDetails'])
            ->get();

        return view('pelanggan.pesanan.index', compact('pesanans'));
    }

    public function create(Mitra $mitra)
    {
        $mitra->load(['layananMitraKiloan.layananKiloan', 'layananMitraSatuan.layananSatuan', 'jamOperasionals']);
        return view('pelanggan.pesanan.create', compact('mitra'));
    }

    public function store(Request $request, Mitra $mitra)
{
    Log::info('PesananController::store - Data diterima pada ' . now() . ': ', $request->all());

    // Validasi data masukan
    $validated = $request->validate([
        'jenis_layanan' => 'required|array|min:1',
        'jenis_layanan.*' => 'in:Kiloan Reguler,Kiloan Ekspres,Satuan',
        'catatan_pesanan' => 'nullable|string',
        'tipe_dp_wajib' => 'required|in:Ya,Tidak',
        'tipe_bisa_lunas' => 'required|in:Ya,Tidak',
        'tanggal_pesan' => 'required|date|after_or_equal:today',
        'opsi_jemput' => 'required|in:Ya,Tidak',
        'jadwal_jemput' => 'required_if:opsi_jemput,Ya|nullable|date|after_or_equal:today',
        'opsi_antar' => 'required|in:Ya,Tidak',
        'jadwal_antar' => 'required_if:opsi_antar,Ya|nullable|date|after_or_equal:today',
        'catatan_pengiriman' => 'nullable|string',
        'layanan_mitra_kiloan_id' => 'required_if:jenis_layanan,Kiloan Reguler,Kiloan Ekspres|exists:layanan_mitra_kiloan,id',
        'berat_sementara' => 'required_if:jenis_layanan,Kiloan Reguler,Kiloan Ekspres|numeric|min:1',
        'satuan' => 'required_if:jenis_layanan,Satuan|array|min:1',
        'satuan.*.layanan_mitra_satuan_id' => 'required_if:jenis_layanan,Satuan|exists:layanan_mitra_satuan,id',
        'satuan.*.jumlah_item' => 'required_if:jenis_layanan,Satuan|integer|min:1',
    ], [
        'layanan_mitra_kiloan_id.exists' => 'Layanan kiloan yang dipilih tidak valid.',
        'satuan.*.layanan_mitra_satuan_id.exists' => 'Layanan satuan yang dipilih tidak valid.',
    ]);

    $layananDipilih = $request->input('jenis_layanan');
    Log::info('PesananController::store - Jenis layanan yang dipilih: ', ['jenis_layanan' => $layananDipilih]);

    // Abaikan satuan jika tidak dipilih
    if (!in_array('Satuan', $layananDipilih) && $request->filled('satuan')) {
        Log::warning('PesananController::store - Data satuan dikirim padahal Satuan tidak dipilih', ['satuan' => $request->satuan]);
        unset($validated['satuan']);
    }

    if (in_array('Kiloan Ekspres', $layananDipilih) && count($layananDipilih) > 1) {
        return back()->withInput()->with('error', 'Kiloan Ekspres tidak dapat digabung dengan layanan lain.');
    }

    $mitra->load('jamOperasionals');

    if ($request->opsi_jemput === 'Ya' && $request->filled('jadwal_jemput')) {
        $this->validateJadwal($request->jadwal_jemput, $mitra);
    }
    if ($request->opsi_antar === 'Ya' && $request->filled('jadwal_antar')) {
        $this->validateJadwal($request->jadwal_antar, $mitra);
    }

    try {
        Log::info('PesananController::store - Mulai membuat pesanan untuk user ' . Auth::id());

        DB::beginTransaction();

        $jenisPesanan = $this->determineJenisPesanan($layananDipilih);
        Log::info('PesananController::store - Jenis pesanan ditentukan: ' . $jenisPesanan);

        // Buat pesanan baru
        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'mitra_id' => $mitra->id,
            'jenis_pesanan' => $jenisPesanan,
            'catatan_pesanan' => $request->catatan_pesanan ?? null,
            'tipe_dp_wajib' => $request->tipe_dp_wajib,
            'tipe_bisa_lunas' => $request->tipe_bisa_lunas,
            'tanggal_pesan' => $request->tanggal_pesan,
            'opsi_jemput' => $request->opsi_jemput,
            'jadwal_jemput' => $request->jadwal_jemput ?? null,
            'opsi_antar' => $request->opsi_antar,
            'jadwal_antar' => $request->jadwal_antar ?? null,
            'catatan_pengiriman' => $request->catatan_pengiriman ?? null,
        ]);

        if (!$pesanan->exists) {
            Log::error('PesananController::store - Gagal membuat pesanan di database.', [
                'data' => $request->all(),
                'mitra_id' => $mitra->id,
            ]);
            throw new \Exception('Gagal menyimpan pesanan ke database.');
        }

        Log::info('PesananController::store - Pesanan berhasil dibuat dengan ID ' . $pesanan->id);

        // Hitung total layanan
        $totalKiloan = 0;
        $totalSatuan = 0;

        if (in_array('Kiloan Reguler', $layananDipilih) || in_array('Kiloan Ekspres', $layananDipilih)) {
            $layananMitraKiloan = $mitra->layananMitraKiloan()->find($request->layanan_mitra_kiloan_id);
            if ($layananMitraKiloan) {
                $hargaPerKg = (int) $layananMitraKiloan->harga_per_kg;
                $beratSementara = (float) $request->berat_sementara;
                $subtotal = (int) round($beratSementara * $hargaPerKg);
                $detailKiloan = PesananDetailKiloan::create([
                    'pesanan_id' => $pesanan->id,
                    'layanan_mitra_kiloan_id' => $request->layanan_mitra_kiloan_id,
                    'berat_sementara' => $beratSementara,
                    'harga_per_kg' => $hargaPerKg,
                    'subtotal' => $subtotal,
                ]);
                if (!$detailKiloan->exists) {
                    Log::error('PesananController::store - Gagal membuat detail kiloan untuk pesanan ID ' . $pesanan->id);
                    throw new \Exception('Gagal menyimpan detail kiloan.');
                }
                $totalKiloan += $subtotal;
                Log::info('PesananController::store - Detail kiloan dibuat untuk pesanan ID ' . $pesanan->id);
            } else {
                Log::error('PesananController::store - Layanan kiloan tidak ditemukan untuk ID: ' . $request->layanan_mitra_kiloan_id);
                throw new \Exception('Layanan kiloan tidak ditemukan untuk ID: ' . $request->layanan_mitra_kiloan_id);
            }
        }

        if (in_array('Satuan', $layananDipilih) && $request->filled('satuan')) {
            foreach ($request->satuan as $index => $satuan) {
                if (!empty($satuan['layanan_mitra_satuan_id']) && !empty($satuan['jumlah_item']) && is_numeric($satuan['jumlah_item']) && $satuan['jumlah_item'] > 0) {
                    $layananMitraSatuan = $mitra->layananMitraSatuan()->find($satuan['layanan_mitra_satuan_id']);
                    if ($layananMitraSatuan) {
                        $hargaPerItem = (int) $layananMitraSatuan->harga_per_item;
                        $subtotal = (int) $satuan['jumlah_item'] * $hargaPerItem;
                        $detailSatuan = PesananDetailSatuan::create([
                            'pesanan_id' => $pesanan->id,
                            'layanan_mitra_satuan_id' => $satuan['layanan_mitra_satuan_id'],
                            'jumlah_item' => $satuan['jumlah_item'],
                            'harga_per_item' => $hargaPerItem,
                            'subtotal' => $subtotal,
                        ]);
                        if (!$detailSatuan->exists) {
                            Log::error('PesananController::store - Gagal membuat detail satuan untuk pesanan ID ' . $pesanan->id . ', item index ' . $index);
                            throw new \Exception('Gagal menyimpan detail satuan untuk index ' . $index);
                        }
                        $totalSatuan += $subtotal;
                        Log::info('PesananController::store - Detail satuan dibuat untuk pesanan ID ' . $pesanan->id . ', item index ' . $index);
                    } else {
                        Log::error('PesananController::store - Layanan satuan tidak ditemukan untuk ID: ' . $satuan['layanan_mitra_satuan_id']);
                        throw new \Exception('Layanan satuan tidak ditemukan untuk ID: ' . $satuan['layanan_mitra_satuan_id']);
                    }
                } else {
                    Log::warning('PesananController::store - Data satuan tidak valid pada index ' . $index . ': ', $satuan);
                    throw new \Exception('Data satuan tidak valid pada index ' . $index);
                }
            }
        }

        $totalTagihan = $totalKiloan + $totalSatuan;
        if ($totalTagihan <= 0) {
            Log::error('PesananController::store - Total tagihan tidak valid: ' . $totalTagihan);
            throw new \Exception("Total tagihan tidak valid: {$totalTagihan}");
        }

        $dpWajib = $request->tipe_dp_wajib === 'Ya' ? ceil($totalTagihan * 0.5) : 0;
        $statusPembayaran = $dpWajib > 0 ? 'belum lunas' : 'lunas';

       $tagihan = Tagihan::create([
    'pesanan_id' => $pesanan->id,
    'order_id' => 'TEMP-' . $pesanan->id . '-' . time() . '-' . uniqid(),
    'total_tagihan' => $totalTagihan,
    'dp_dibayar' => 0,
    'sisa_tagihan' => $totalTagihan,
    'status_pembayaran' => $statusPembayaran,
    'jatuh_tempo_pelunasan' => $dpWajib > 0 ? Carbon::now()->addDays(7) : null,
]);

        if (!$tagihan->exists) {
            Log::error('PesananController::store - Gagal membuat tagihan untuk pesanan ID ' . $pesanan->id);
            throw new \Exception('Gagal menyimpan tagihan.');
        }

        Log::info('PesananController::store - Tagihan berhasil dibuat dengan ID ' . $tagihan->id);

        DB::commit();

        return redirect()->route('pelanggan.tagihan.bayar', $tagihan->id)
            ->with('info', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran DP.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('PesananController::store - Gagal membuat pesanan pada ' . now() . ': ' . $e->getMessage(), [
            'exception' => $e->getMessage(),
            'stack_trace' => $e->getTraceAsString(),
            'request_data' => $request->all(),
            'user_id' => Auth::id(),
            'mitra_id' => $mitra->id,
        ]);
        return back()->withInput()->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
    }
}
    

    private function validateJadwal($jadwal, $mitra)
    {
        $jadwal = Carbon::parse($jadwal);
        $hari = $jadwal->locale('id')->isoFormat('dddd');
        $jam = $jadwal->format('H:i');

        $jamOperasional = $mitra->jamOperasionals->firstWhere('hari_buka', $hari);

        if (!$jamOperasional) {
            throw new \Exception('Mitra tidak buka pada hari tersebut.');
        }
        if ($jam < $jamOperasional->jam_buka || $jam > $jamOperasional->jam_tutup) {
            throw new \Exception('Waktu di luar jam operasional.');
        }
    }

    private function determineJenisPesanan($layananDipilih)
    {
        if (in_array('Satuan', $layananDipilih)) {
            if (in_array('Kiloan Reguler', $layananDipilih) || in_array('Kiloan Ekspres', $layananDipilih)) {
                return 'Kiloan + Satuan';
            }
            return 'Satuan';
        }
        if (in_array('Kiloan Ekspres', $layananDipilih)) {
            return 'Kiloan Ekspres';
        }
        if (in_array('Kiloan Reguler', $layananDipilih)) {
            return 'Kiloan Reguler';
        }
        throw new \Exception('Jenis pesanan tidak valid. Silakan pilih setidaknya satu jenis layanan.');
    }
}