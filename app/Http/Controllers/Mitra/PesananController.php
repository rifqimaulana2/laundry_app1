<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Models
use App\Models\User;
use App\Models\WalkinCustomer;
use App\Models\LayananMitraKiloan;
use App\Models\LayananMitraSatuan;
use App\Models\Pesanan;
use App\Models\PesananDetailKiloan;
use App\Models\PesananDetailSatuan;
use App\Models\JamOperasional;
use App\Models\StatusMaster;
use App\Models\TrackingStatus;
use App\Models\Tagihan; // ⬅️ tambahkan import Tagihan

class PesananController extends Controller
{
    /** ================================
     * INDEX - List Pesanan
     * ================================ */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'mitra') {
            $mitraId = $user->mitra->id;
        } elseif ($user->role === 'employee') {
            $mitraId = $user->employee->mitra_id;
        } else {
            abort(403, 'Tidak ditemukan mitra untuk user ini.');
        }

        if (!$mitraId) {
            abort(403, 'Tidak ditemukan mitra untuk user ini.');
        }

        $query = Pesanan::with([
            'user.pelangganProfile',
            'walkinCustomer',
            'trackingStatus.statusMaster',
            'tagihan'
        ])
        ->where('mitra_id', $mitraId)
        ->where(function ($q) {
            $q->whereNotNull('user_id')
              ->orWhereNotNull('walkin_customer_id');
        });

        if ($request->filled('jenis')) {
            $query->where('jenis_pesanan', $request->jenis);
        }
        if ($request->filled('jemput')) {
            $query->where('opsi_jemput', $request->jemput);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($x) use ($q) {
                $x->where('id', $q)
                  ->orWhere('catatan_pesanan', 'like', "%$q%")
                  ->orWhereHas('user', function ($u) use ($q) {
                      $u->where('name', 'like', "%$q%")
                        ->orWhere('email', 'like', "%$q%");
                  })
                  ->orWhereHas('user.pelangganProfile', function ($p) use ($q) {
                      $p->where('alamat', 'like', "%$q%")
                        ->orWhere('no_telepon', 'like', "%$q%");
                  })
                  ->orWhereHas('walkinCustomer', function ($w) use ($q) {
                      $w->where('name', 'like', "%$q%")
                        ->orWhere('no_telepon', 'like', "%$q%")
                        ->orWhere('alamat', 'like', "%$q%");
                  });
            });
        }

        $pesanans = $query->orderByDesc('created_at')->paginate(15);

        // Mapping data pelanggan
        $pesanans->getCollection()->transform(function ($pesanan) {
            if ($pesanan->walkinCustomer && $pesanan->walkinCustomer->id) {
                $pesanan->nama_pelanggan    = $pesanan->walkinCustomer->name;
                $pesanan->telepon_pelanggan = $pesanan->walkinCustomer->no_telepon ?? '-';
                $pesanan->alamat_pelanggan  = $pesanan->walkinCustomer->alamat ?? '-';
            } elseif ($pesanan->user && $pesanan->user->id) {
                $pesanan->nama_pelanggan    = $pesanan->user->name ?? '—';
                $pesanan->telepon_pelanggan = optional($pesanan->user->pelangganProfile)->no_telepon ?? '-';
                $pesanan->alamat_pelanggan  = optional($pesanan->user->pelangganProfile)->alamat ?? '-';
            } else {
                $pesanan->nama_pelanggan    = '—';
                $pesanan->telepon_pelanggan = '-';
                $pesanan->alamat_pelanggan  = '-';
            }
            return $pesanan;
        });

        // Status Map
        $statusMap = StatusMaster::all()->mapWithKeys(function($status) {
            $statusLower = strtolower($status->nama_status);
            return [
                $statusLower => [
                    'id'    => $status->id,
                    'color' => match($statusLower) {
                        'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-700',
                        'diproses'            => 'bg-blue-100 text-blue-700',
                        'dijemput'            => 'bg-indigo-100 text-indigo-700',
                        'diantar'             => 'bg-purple-100 text-purple-700',
                        'selesai'             => 'bg-green-100 text-green-700',
                        'dibatalkan'          => 'bg-red-100 text-red-700',
                        default               => 'bg-gray-100 text-gray-600',
                    }
                ]
            ];
        })->toArray();

        return view('mitra.pesanan.index', compact('pesanans', 'statusMap'));
    }

    /** ================================
     * CREATE - Form Tambah Pesanan
     * ================================ */
    public function create()
    {
        $mitra = Auth::user()->mitra;
        $mitraId = $mitra->id;

        $pelanggans       = User::where('role', 'pelanggan')->with('pelangganProfile')->get();
        $walkinCustomers  = WalkinCustomer::where('mitra_id', $mitraId)->orderBy('name')->get();
        $layananKiloan    = LayananMitraKiloan::with('layananKiloan')->where('mitra_id', $mitraId)->get();
        $layananSatuan    = LayananMitraSatuan::with('layananSatuan')->where('mitra_id', $mitraId)->get();
        $jamOperasional   = JamOperasional::where('mitra_id', $mitraId)->get();

        $layananJemputAktif = strtolower($mitra->layanan_jemput ?? 'tidak') === 'ya';
        $layananAntarAktif  = strtolower($mitra->layanan_antar ?? 'tidak') === 'ya';

        return view('mitra.pesanan.create', compact(
            'pelanggans', 'walkinCustomers', 'layananKiloan', 'layananSatuan',
            'jamOperasional', 'layananJemputAktif', 'layananAntarAktif', 'mitra'
        ));
    }

    /** ================================
     * STORE - Simpan Pesanan Baru
     * ================================ */
    public function store(Request $request)
    {
        $mitra = Auth::user()->mitra;
        $mitraId = $mitra->id;

        $opsiJemput = strtolower($mitra->layanan_jemput ?? 'tidak') === 'ya' ? $request->input('opsi_jemput', 'Tidak') : 'Tidak';
        $opsiAntar  = strtolower($mitra->layanan_antar ?? 'tidak') === 'ya' ? $request->input('opsi_antar', 'Tidak')  : 'Tidak';

        $request->validate([
            'pelanggan_tipe'  => 'required|in:online,walkin,walkin_existing',
            'user_id'         => 'required_if:pelanggan_tipe,online|nullable|exists:users,id',
            'walkin_customer_id' => 'required_if:pelanggan_tipe,walkin_existing|nullable|exists:walkin_customers,id',
            'name'            => 'required_if:pelanggan_tipe,walkin|nullable|string|max:100',
            'alamat'          => 'required_if:pelanggan_tipe,walkin|nullable|string|max:255',
            'no_telepon'      => 'required_if:pelanggan_tipe,walkin|nullable|string|max:30',
            'jenis_pesanan'   => 'required|in:Kiloan,Satuan,Kiloan + Satuan',
            'jadwal_jemput'   => 'nullable|date',
            'jadwal_antar'    => 'nullable|date',
        ]);

        if (in_array($request->jenis_pesanan, ['Kiloan', 'Kiloan + Satuan'])) {
            $request->validate([
                'kiloan_selected' => 'required|integer|exists:layanan_mitra_kiloan,id',
                "kiloan.{$request->kiloan_selected}.berat" => 'required|numeric|min:1',
            ]);
        }

        if (in_array($request->jenis_pesanan, ['Satuan', 'Kiloan + Satuan'])) {
            $adaSatuan = false;
            foreach (($request->satuan ?? []) as $sid => $item) {
                if (!empty($item['layanan_id']) && intval($item['jumlah']) > 0) {
                    $adaSatuan = true; break;
                }
            }
            if (!$adaSatuan) {
                return back()->withErrors(['satuan' => 'Pilih minimal satu item layanan satuan dan isi jumlahnya.'])->withInput();
            }
        }

        $cekJadwal = function (?string $datetime) use ($mitraId) {
            if (!$datetime) return true;
            $dt   = Carbon::parse($datetime);
            $hari = $dt->locale('id')->dayName;
            $record = JamOperasional::where('mitra_id', $mitraId)->where('hari_buka', $hari)->first();
            if (!$record) return true;
            $jam  = $dt->format('H:i:s');
            return ($jam >= $record->jam_buka && $jam <= $record->jam_tutup);
        };
        if ($opsiJemput === 'Ya' && !$cekJadwal($request->jadwal_jemput)) {
            return back()->withErrors(['jadwal_jemput' => 'Jadwal jemput di luar jam operasional mitra.'])->withInput();
        }
        if ($opsiAntar === 'Ya' && !$cekJadwal($request->jadwal_antar)) {
            return back()->withErrors(['jadwal_antar' => 'Jadwal antar di luar jam operasional mitra.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $userId = null; $walkinId = null;
            if ($request->pelanggan_tipe === 'online') {
                $userId = $request->user_id;
            } elseif ($request->pelanggan_tipe === 'walkin') {
                $walkinId = WalkinCustomer::create([
                    'mitra_id' => $mitraId,
                    'name'     => $request->name,
                    'alamat'   => $request->alamat,
                    'no_telepon' => $request->no_telepon,
                ])->id;
            } else {
                $walkinId = $request->walkin_customer_id;
            }

            $pesanan = Pesanan::create([
                'user_id'            => $userId,
                'walkin_customer_id' => $walkinId,
                'mitra_id'           => $mitraId,
                'jenis_pesanan'      => $request->jenis_pesanan,
                'catatan_pesanan'    => $request->catatan_pesanan,
                'tanggal_pesan'      => now()->format('Y-m-d'),
                'opsi_jemput'        => $opsiJemput,
                'jadwal_jemput'      => $opsiJemput === 'Ya' ? $request->jadwal_jemput : null,
                'opsi_antar'         => $opsiAntar,
                'jadwal_antar'       => $opsiAntar === 'Ya' ? $request->jadwal_antar : null,
                'tipe_dp_wajib'      => 'Ya',
                'tipe_bisa_lunas'    => 'Tidak',
            ]);

            // ===== Detail Kiloan
            if (in_array($request->jenis_pesanan, ['Kiloan', 'Kiloan + Satuan'])) {
                $kid   = $request->kiloan_selected;
                $berat = (float) $request->kiloan[$kid]['berat'];
                $harga = (float) $request->kiloan[$kid]['harga'];
                PesananDetailKiloan::create([
                    'pesanan_id'               => $pesanan->id,
                    'layanan_mitra_kiloan_id'  => $kid,
                    'berat_sementara'          => $berat,
                    'harga_per_kg'             => $harga,
                    'subtotal'                 => $berat * $harga,
                ]);
            }

            // ===== Detail Satuan
            if (in_array($request->jenis_pesanan, ['Satuan', 'Kiloan + Satuan'])) {
                foreach (($request->satuan ?? []) as $sid => $item) {
                    if (!empty($item['layanan_id']) && intval($item['jumlah']) > 0) {
                        $jumlah = (int) $item['jumlah'];
                        $harga  = (float) $item['harga'];
                        PesananDetailSatuan::create([
                            'pesanan_id'              => $pesanan->id,
                            'layanan_mitra_satuan_id' => $sid,
                            'jumlah_item'             => $jumlah,
                            'harga_per_item'          => $harga,
                            'subtotal'                => $jumlah * $harga,
                        ]);
                    }
                }
            }

            // ===== Buat/Sync Tagihan awal (berdasar subtotal sementara)
            $totalKiloan = PesananDetailKiloan::where('pesanan_id', $pesanan->id)->sum('subtotal');
            $totalSatuan = PesananDetailSatuan::where('pesanan_id', $pesanan->id)->sum('subtotal');
            $totalAwal   = $totalKiloan + $totalSatuan;

            Tagihan::firstOrCreate(
                ['pesanan_id' => $pesanan->id],
                [
                    'total_tagihan' => $totalAwal,
                    'dp_dibayar'    => 0,
                    'sisa_tagihan'  => $totalAwal, // belum ada DP
                ]
            );

            DB::commit();
            return redirect()->route('mitra.pesanan.index')->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat pesanan: '.$e->getMessage()])->withInput();
        }
    }

    /** ================================
     * SHOW - Detail Pesanan
     * ================================ */
    public function show($id)
    {
        // ⬅️ Samakan logika ambil mitra_id seperti di index(), agar employee juga aman
        $user = Auth::user();
        if ($user->role === 'mitra') {
            $mitraId = $user->mitra->id;
        } elseif ($user->role === 'employee') {
            $mitraId = $user->employee->mitra_id;
        } else {
            abort(403, 'Tidak ditemukan mitra untuk user ini.');
        }

        $pesanan = Pesanan::with([
            'user.pelangganProfile',
            'walkinCustomer',
            'kiloanDetails.layananMitraKiloan.layananKiloan',
            'satuanDetails.layananMitraSatuan.layananSatuan',
            'trackingStatus.statusMaster',
            'tagihan'
        ])
        ->where('mitra_id', $mitraId)
        ->findOrFail($id);

        $statusList = StatusMaster::all();
        return view('mitra.pesanan.show', compact('pesanan', 'statusList'));
    }

    /** ================================
     * UPDATE TIMBANGAN KILOAN
     * ================================ */
   public function updateTimbangan(Request $request, $detailId)
{
    $request->validate([
        'berat_final' => 'required|numeric|min:1'
    ]);

    return DB::transaction(function () use ($request, $detailId) {
        $detail  = PesananDetailKiloan::lockForUpdate()->findOrFail($detailId);
        $pesanan = Pesanan::with('tagihan')->lockForUpdate()->findOrFail($detail->pesanan_id);

        // Jika tagihan belum ada → buat tapi tetap larang konfirmasi sebelum DP
        if (!$pesanan->tagihan) {
            $totalKiloan0 = PesananDetailKiloan::where('pesanan_id', $pesanan->id)->sum('subtotal');
            $totalSatuan0 = PesananDetailSatuan::where('pesanan_id', $pesanan->id)->sum('subtotal');
            $total0       = $totalKiloan0 + $totalSatuan0;

            $pesanan->tagihan = Tagihan::create([
                'pesanan_id'    => $pesanan->id,
                'total_tagihan' => $total0,
                'dp_dibayar'    => 0,
                'sisa_tagihan'  => $total0,
                'status_pembayaran' => 'belum lunas',
            ]);

            return back()->with('error', 'Tagihan dibuat otomatis. Mohon minta pelanggan bayar DP terlebih dahulu.');
        }

        // Validasi DP sudah dibayar
        if ($pesanan->tagihan->dp_dibayar <= 0) {
            return back()->with('error', 'Tidak bisa konfirmasi timbangan sebelum DP dibayar.');
        }

        // ✅ Update berat final & subtotal kiloan
        $detail->berat_final = $request->berat_final;
        $detail->subtotal    = $detail->berat_final * $detail->harga_per_kg;
        $detail->save();

        // ✅ Hitung ulang tagihan pakai method di model
        $pesanan->tagihan->calculateTotalTagihan();

        return back()->with('success', 'Berat final berhasil diperbarui dan total tagihan dihitung ulang.');
    });
}

    /** ================================
     * UPDATE STATUS
     * ================================ */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_master_id' => 'required|exists:status_master,id',
            'pesan'            => 'nullable|string|max:500',
        ]);

        TrackingStatus::create([
            'pesanan_id'       => $id,
            'status_master_id' => $request->status_master_id,
            'waktu'            => now(),
            'user_id'          => Auth::id(),
            'mitra_id'         => Auth::user()->mitra->id,
            'pesan'            => $request->pesan
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /** ================================
     * HAPUS PESANAN
     * ================================ */
    public function destroy($id)
    {
        $pesanan = Pesanan::where('mitra_id', Auth::user()->mitra->id)->findOrFail($id);
        $pesanan->trackingStatus()->delete();
        $pesanan->kiloanDetails()->delete();
        $pesanan->satuanDetails()->delete();
        $pesanan->delete();

        return redirect()->route('mitra.pesanan.index')->with('success', 'Pesanan dihapus.');
    }
}
