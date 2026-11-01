<?php
namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\{Pembayaran, PengajuanPengambilan, PeriodePemeliharaan, Transaksi};
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PortalController extends Controller
{
    private function mitra() { return auth()->user()->mitra; }

    private function transaksiSaya()
    {
        return Transaksi::with('pengajuan.periode', 'pembayaran')
            ->whereHas('pengajuan', fn ($q) => $q->where('id_mitra', $this->mitra()->id_mitra));
    }

    private function periodeAktif() { return PeriodePemeliharaan::with('stok')->berjalan()->latest('tgl_mulai')->first(); }

    public function dashboard()
    {
        $mitra = $this->mitra();
        $periode = $this->periodeAktif();
        $stok = $periode?->stok?->jumlah_tersedia ?? 0;
        $awal = $periode?->jumlah_awal_ayam ?? 0;
        $trx = $this->transaksiSaya()->get();

        return view('mitra.dashboard', [
            'mitra' => $mitra, 'periode' => $periode, 'stok' => $stok,
            'persenStok' => $awal ? round($stok / $awal * 100) : 0,
            'menunggu' => $mitra->pengajuan()->where('status', 'menunggu')->count(),
            'diambil' => (int) $trx->sum('jumlah_diambil'),
            'sisa' => (int) $trx->sum(fn ($t) => $t->sisa),
            'pengajuan' => $mitra->pengajuan()->with('transaksi.pembayaran')->latest('id_pengajuan')->take(5)->get(),
        ]);
    }

    public function pengajuan()
    {
        $mitra = $this->mitra();
        $periode = $this->periodeAktif();
        return view('mitra.pengajuan', [
            'mitra' => $mitra, 'periode' => $periode, 'stok' => $periode?->stok?->jumlah_tersedia ?? 0,
            'list' => $mitra->pengajuan()->with('periode', 'transaksi')->latest('id_pengajuan')->paginate(10),
        ]);
    }

    public function storePengajuan(Request $r)
    {
        $mitra = $this->mitra();
        if ($mitra->status_verifikasi !== 'terverifikasi') {
            throw ValidationException::withMessages(['jumlah_diminta' => 'Akun Anda belum terverifikasi, pengajuan belum dapat dikirim.']);
        }
        $periode = $this->periodeAktif();
        if (! $periode) {
            throw ValidationException::withMessages(['jumlah_diminta' => 'Belum ada periode yang berjalan.']);
        }
        $stok = $periode->stok?->jumlah_tersedia ?? 0;

        $d = $r->validate([
            'jumlah_diminta'  => ['required', 'integer', 'min:1', 'max:' . $stok],
            'tgl_pengambilan' => ['required', 'date', 'after_or_equal:today'],
        ], ['jumlah_diminta.max' => "Jumlah melebihi stok tersedia ({$stok} ekor)."]);

        PengajuanPengambilan::create($d + ['id_mitra' => $mitra->id_mitra, 'id_periode' => $periode->id_periode, 'status' => 'menunggu']);
        return back()->with('ok', 'Pengajuan dikirim, menunggu diproses admin');
    }

    public function transaksi()
    {
        return view('mitra.transaksi', ['list' => $this->transaksiSaya()->orderByDesc('id_transaksi')->paginate(10)]);
    }

    public function pembayaran()
    {
        $trx = $this->transaksiSaya()->get();
        $list = Pembayaran::with('transaksi.pengajuan')
            ->whereHas('transaksi.pengajuan', fn ($q) => $q->where('id_mitra', $this->mitra()->id_mitra))
            ->orderByDesc('id_pembayaran')->paginate(10);
        return view('mitra.pembayaran', [
            'list' => $list, 'tagihan' => (int) $trx->sum('total_harga'),
            'dibayar' => (int) $trx->sum(fn ($t) => $t->total_dibayar), 'sisa' => (int) $trx->sum(fn ($t) => $t->sisa),
            'belumLunas' => $trx->filter(fn ($t) => $t->sisa > 0),
        ]);
    }
}
