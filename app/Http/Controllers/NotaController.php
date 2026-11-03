<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\URL;

class NotaController extends Controller
{
    /** Nota siap cetak / simpan PDF (lewat dialog cetak browser) dengan QR pengambilan. */
    public function show(Transaksi $transaksi)
    {
        $transaksi->load('pengajuan.mitra', 'pengajuan.periode', 'pembayaran');
        $user = auth()->user();
        abort_unless($user->isAdmin() || $transaksi->pengajuan->id_mitra === $user->mitra?->id_mitra, 403);

        // QR berisi tautan bertanda tangan: hanya admin yang login yang dapat mengonfirmasi pengambilan
        $tautan = URL::signedRoute('admin.transaksi.scan', $transaksi);
        $facade = \SimpleSoftwareIO\QrCode\Facades\QrCode::class;
        $qr = class_exists($facade) ? (string) $facade::format('svg')->size(150)->margin(0)->generate($tautan) : null;

        return view('nota', ['t' => $transaksi, 'qr' => $qr, 'tautan' => $tautan]);
    }
}
