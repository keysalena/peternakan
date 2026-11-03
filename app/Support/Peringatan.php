<?php
namespace App\Support;

use App\Models\{AktivitasPemeliharaan, Mitra, PeriodePemeliharaan, Transaksi};
use Illuminate\Support\Carbon;

/** Aturan peringatan otomatis (tanpa AI): stok, mortalitas harian, dan tagihan lewat jatuh tempo. */
class Peringatan
{
    /** @return array<int, array{level:string,judul:string,pesan:string,url:?string}> level: c (kritis) | w (waspada) */
    public static function admin(): array
    {
        $out = [];
        $p = PeriodePemeliharaan::with('stok')->berjalan()->latest('tgl_mulai')->first();

        if ($p && $p->stok) {
            $awal = max($p->jumlah_awal_ayam, 1);
            $stok = $p->stok->jumlah_tersedia;
            $persen = $stok / $awal * 100;

            if ($stok === 0) {
                $out[] = self::item('c', 'Stok habis', "Stok {$p->nama_periode} sudah 0 ekor.", route('admin.stok.index'));
            } elseif ($persen <= config('ternakku.stok_minimum_persen')) {
                $out[] = self::item('w', 'Stok menipis', 'Tersisa ' . number_format($stok, 0, ',', '.') . ' ekor (' . round($persen) . '% dari jumlah awal).', route('admin.stok.index'));
            }

            $batas = $awal * config('ternakku.mortalitas_harian_persen') / 100;
            $hari = AktivitasPemeliharaan::where('id_periode', $p->id_periode)
                ->whereDate('tanggal', '>=', today()->subDays(7))
                ->selectRaw('tanggal, sum(mortalitas) as total')->groupBy('tanggal')
                ->having('total', '>', $batas)->orderByDesc('tanggal')->first();
            if ($hari) {
                $out[] = self::item('w', 'Mortalitas tinggi', "{$hari->total} ekor mati pada " . Carbon::parse($hari->tanggal)->translatedFormat('j M') . ', di atas batas ' . (int) ceil($batas) . ' ekor per hari.', route('admin.aktivitas.index'));
            }
        }
        return array_merge($out, self::tagihan(null));
    }

    public static function mitra(Mitra $mitra): array
    {
        $out = self::tagihan($mitra->id_mitra);
        $p = PeriodePemeliharaan::with('stok')->berjalan()->latest('tgl_mulai')->first();
        if ($p && $p->stok && $p->stok->jumlah_tersedia / max($p->jumlah_awal_ayam, 1) * 100 <= config('ternakku.stok_minimum_persen')) {
            $out[] = self::item('w', 'Stok menipis', 'Stok periode berjalan hampir habis. Ajukan pengambilan lebih awal.', route('mitra.pengajuan.index'));
        }
        return $out;
    }

    private static function tagihan(?int $idMitra): array
    {
        $hari = (int) config('ternakku.jatuh_tempo_hari');
        $telat = Transaksi::with('pembayaran')
            ->whereDate('tgl_transaksi', '<=', today()->subDays($hari))
            ->when($idMitra, fn ($q) => $q->whereHas('pengajuan', fn ($w) => $w->where('id_mitra', $idMitra)))
            ->get()->filter(fn ($t) => $t->sisa > 0);
        if ($telat->isEmpty()) return [];

        return [self::item('c', 'Tagihan lewat jatuh tempo',
            "{$telat->count()} transaksi belum lunas lebih dari {$hari} hari, sisa Rp " . number_format($telat->sum('sisa'), 0, ',', '.') . '.',
            route($idMitra ? 'mitra.pembayaran.index' : 'admin.pembayaran.index'))];
    }

    private static function item(string $level, string $judul, string $pesan, ?string $url): array
    {
        return compact('level', 'judul', 'pesan', 'url');
    }
}
