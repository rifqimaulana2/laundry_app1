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
        $this->middleware(['auth', 'role:pelanggan']);
    }

    /**
     * Daftar pesanan pelanggan
     */
    public function index()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())
            ->with([
                'mitra',
                'tagihan',
                'kiloanDetails',
                'satuanDetails'
            ])
            ->latest()
            ->get();

        return view('pelanggan.pesanan.index', compact('pesanans'));
    }

    /**
     * Form buat pesanan baru berdasarkan mitra
     */
    public function create(Mitra $mitra)
    {
        $mitra->load([
            'layananMitraKiloan.layananKiloan',
            'layananMitraSatuan.layananSatuan',
            'jamOperasionals'
        ]);

        return view('pelanggan.pesanan.create', compact('mitra'));
    }

    /**
     * Simpan pesanan baru
     */
    public function store(Request $request, Mitra $mitra)
    {
        Log::info('PesananController::store - Data request:', $request->all());

        $validated = $request->validate([
            'jenis_layanan' => 'required|array|min:1',
            'jenis_layanan.*' => 'in:Kiloan Reguler,Kiloan Ekspres,Satuan',

            'catatan_pesanan' => 'nullable|string',
            'tipe_dp_wajib'   => 'required|in:Ya,Tidak',
            'tipe_bisa_lunas' => 'required|in:Ya,Tidak',
            'tanggal_pesan'   => 'required|date|after_or_equal:today',

            'opsi_jemput'     => 'required|in:Ya,Tidak',
            'jadwal_jemput'   => 'required_if:opsi_jemput,Ya|nullable|date|after_or_equal:today',

            'opsi_antar'      => 'required|in:Ya,Tidak',
            'jadwal_antar'    => 'required_if:opsi_antar,Ya|nullable|date|after_or_equal:today',

            'catatan_pengiriman' => 'nullable|string',

            // Kiloan
            'layanan_mitra_kiloan_id' => 'required_if:jenis_layanan,Kiloan Reguler,Kiloan Ekspres|exists:layanan_mitra_kiloan,id',
            'berat_sementara'         => 'required_if:jenis_layanan,Kiloan Reguler,Kiloan Ekspres|numeric|min:1',

            // Satuan
            'satuan' => 'required_if:jenis_layanan,Satuan|array|min:1',
            'satuan.*.layanan_mitra_satuan_id' => 'required_if:jenis_layanan,Satuan|exists:layanan_mitra_satuan,id',
            'satuan.*.jumlah_item'             => 'required_if:jenis_layanan,Satuan|integer|min:1',
        ]);

        $layananDipilih = $request->jenis_layanan;

        // Aturan khusus
        if (in_array('Kiloan Ekspres', $layananDipilih) && count($layananDipilih) > 1) {
            return back()->withInput()->with('error', 'Kiloan Ekspres tidak dapat digabung dengan layanan lain.');
        }

        try {
            DB::beginTransaction();

            $jenisPesanan = $this->determineJenisPesanan($layananDipilih);

            $pesanan = Pesanan::create([
                'user_id'            => Auth::id(),
                'mitra_id'           => $mitra->id,
                'jenis_pesanan'      => $jenisPesanan,
                'catatan_pesanan'    => $request->catatan_pesanan,
                'tipe_dp_wajib'      => $request->tipe_dp_wajib,
                'tipe_bisa_lunas'    => $request->tipe_bisa_lunas,
                'tanggal_pesan'      => $request->tanggal_pesan,
                'opsi_jemput'        => $request->opsi_jemput,
                'jadwal_jemput'      => $request->jadwal_jemput,
                'opsi_antar'         => $request->opsi_antar,
                'jadwal_antar'       => $request->jadwal_antar,
                'catatan_pengiriman' => $request->catatan_pengiriman,
            ]);

            if (!$pesanan->exists) {
                throw new \Exception('Gagal menyimpan pesanan.');
            }

            $totalKiloan = 0;
            $totalSatuan = 0;

            // Detail Kiloan
            if (in_array('Kiloan Reguler', $layananDipilih) || in_array('Kiloan Ekspres', $layananDipilih)) {
                $layananMitraKiloan = $mitra->layananMitraKiloan()->find($request->layanan_mitra_kiloan_id);

                if (!$layananMitraKiloan) {
                    throw new \Exception('Layanan kiloan tidak ditemukan.');
                }

                $hargaPerKg = (int) $layananMitraKiloan->harga_per_kg;
                $berat = (float) $request->berat_sementara;
                $subtotal = (int) round($berat * $hargaPerKg);

                PesananDetailKiloan::create([
                    'pesanan_id'              => $pesanan->id,
                    'layanan_mitra_kiloan_id' => $request->layanan_mitra_kiloan_id,
                    'berat_sementara'         => $berat,
                    'harga_per_kg'            => $hargaPerKg,
                    'subtotal'                => $subtotal,
                ]);

                $totalKiloan += $subtotal;
            }

            // Detail Satuan
            if (in_array('Satuan', $layananDipilih) && $request->filled('satuan')) {
                foreach ($request->satuan as $satuan) {
                    $layananMitraSatuan = $mitra->layananMitraSatuan()->find($satuan['layanan_mitra_satuan_id']);

                    if (!$layananMitraSatuan) {
                        throw new \Exception('Layanan satuan tidak ditemukan.');
                    }

                    $hargaPerItem = (int) $layananMitraSatuan->harga_per_item;
                    $subtotal = $satuan['jumlah_item'] * $hargaPerItem;

                    PesananDetailSatuan::create([
                        'pesanan_id'              => $pesanan->id,
                        'layanan_mitra_satuan_id' => $satuan['layanan_mitra_satuan_id'],
                        'jumlah_item'             => $satuan['jumlah_item'],
                        'harga_per_item'          => $hargaPerItem,
                        'subtotal'                => $subtotal,
                    ]);

                    $totalSatuan += $subtotal;
                }
            }

            $totalTagihan = $totalKiloan + $totalSatuan;
            if ($totalTagihan <= 0) {
                throw new \Exception('Total tagihan tidak valid.');
            }

            $dpWajib = $request->tipe_dp_wajib === 'Ya' ? ceil($totalTagihan * 0.5) : 0;
            $statusPembayaran = $dpWajib > 0 ? 'belum lunas' : 'lunas';

            Tagihan::create([
                'pesanan_id'            => $pesanan->id,
                'order_id'              => 'ORD-' . $pesanan->id . '-' . time(),
                'total_tagihan'         => $totalTagihan,
                'dp_dibayar'            => 0,
                'sisa_tagihan'          => $totalTagihan,
                'status_pembayaran'     => $statusPembayaran,
                'jatuh_tempo_pelunasan' => $dpWajib > 0 ? Carbon::now()->addDays(7) : null,
            ]);

            DB::commit();

            return redirect()
    ->route('pelanggan.pesanan.show', ['pesanan' => $pesanan->id])
    ->with('success', 'Pesanan berhasil dibuat.');


        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PesananController::store - Error: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
            ]);
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Tampilkan detail item pesanan
     */
    public function show(Pesanan $pesanan)
    {
        abort_if($pesanan->user_id !== Auth::id(), 403);

        $pesanan->load([
            'kiloanDetails.layananMitraKiloan.layananKiloan',
            'satuanDetails.layananMitraSatuan.layananSatuan',
        ]);

        return view('pelanggan.pesanan.show', compact('pesanan'));
    }

    /**
     * Tentukan jenis pesanan (helper internal)
     */
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
        throw new \Exception('Jenis pesanan tidak valid.');
    }
}
