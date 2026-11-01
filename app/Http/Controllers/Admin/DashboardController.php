<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{AktivitasPemeliharaan, Mitra, Pembayaran, PengajuanPengambilan, PeriodePemeliharaan, Transaksi};

class DashboardController extends Controller
{
    public function index()
    {
        $periode = PeriodePemeliharaan::with('stok')->berjalan()->latest('tgl_mulai')->first();
        $stok = $periode?->stok?->jumlah_tersedia ?? 0;
        $awal = $periode?->jumlah_awal_ayam ?? 0;
        $mati = $periode ? (int) $periode->aktivitas()->sum('mortalitas') : 0;

        $totalMitra = Mitra::count();
        $mitraOk = Mitra::where('status_verifikasi', 'terverifikasi')->count();
        $totalPengajuan = PengajuanPengambilan::count();
        $menunggu = PengajuanPengambilan::where('status', 'menunggu')->count();

        $tagihan = (int) Transaksi::sum('total_harga');
        $masuk = (int) Pembayaran::where('status', '!=', 'gagal')->sum('jumlah_bayar');
        $belum = max($tagihan - $masuk, 0);

        // grafik: jumlah pengajuan per hari, 7 hari terakhir
        $perHari = PengajuanPengambilan::whereDate('created_at', '>=', today()->subDays(6))
            ->get()->groupBy(fn ($p) => $p->created_at->toDateString())->map->count();
        $grafik = collect(range(6, 0))->map(fn ($i) => [
            'hari' => today()->subDays($i)->locale('id')->isoFormat('ddd'),
            'n'    => $perHari[today()->subDays($i)->toDateString()] ?? 0,
        ]);

        return view('admin.dashboard.index', [
            'periode' => $periode, 'stok' => $stok, 'awal' => $awal, 'mati' => $mati,
            'persenStok' => $awal ? round($stok / $awal * 100) : 0,
            'persenMati' => $awal ? round($mati / $awal * 100, 1) : 0,
            'totalMitra' => $totalMitra, 'mitraOk' => $mitraOk,
            'menunggu' => $menunggu, 'persenMenunggu' => $totalPengajuan ? round($menunggu / $totalPengajuan * 100) : 0,
            'belum' => $belum, 'persenBelum' => $tagihan ? round($belum / $tagihan * 100) : 0,
            'grafik' => $grafik, 'maks' => max($grafik->max('n'), 1),
            'mitraBaru' => Mitra::latest('id_mitra')->take(4)->get(),
            'pengajuan' => PengajuanPengambilan::with('mitra', 'transaksi.pembayaran')->latest('id_pengajuan')->take(4)->get(),
            'aktivitas' => AktivitasPemeliharaan::latest('tanggal')->latest('id_aktivitas')->take(4)->get(),
            'mitraSelect' => Mitra::where('status_verifikasi', 'terverifikasi')->orderBy('nama_perusahaan')->get(),
            'periodeSelect' => PeriodePemeliharaan::where('status', 'berjalan')->get(),
        ]);
    }
}
