<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{PengajuanPengambilan, StokAyam, Transaksi};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransaksiController extends Controller
{
    public function index()
    {
        $list = Transaksi::with('pengajuan.mitra', 'pembayaran')->orderByDesc('id_transaksi')->paginate(10);
        $tagihan = (int) Transaksi::sum('total_harga');
        return view('admin.transaksi.index', ['list' => $list, 'tagihan' => $tagihan, 'jumlah' => Transaksi::count(),
            'diambil' => (int) Transaksi::sum('jumlah_diambil'), 'openTrx' => Transaksi::with('pengajuan.mitra', 'pembayaran')->get()->filter(fn ($t) => $t->sisa > 0)]);
    }

    /** Memproses pengajuan -> membuat transaksi dan mengurangi stok secara otomatis (atomik). */
    public function store(Request $r, PengajuanPengambilan $pengajuan)
    {
        $d = $r->validate([
            'jumlah_diambil' => ['required', 'integer', 'min:1', 'max:' . $pengajuan->jumlah_diminta],
            'harga_per_ekor' => ['required', 'integer', 'min:1'],
            'tgl_transaksi'  => ['required', 'date'],
        ], ['jumlah_diambil.max' => 'Jumlah diambil melebihi jumlah yang diminta mitra.']);

        DB::transaction(function () use ($pengajuan, $d) {
            $p = PengajuanPengambilan::lockForUpdate()->findOrFail($pengajuan->id_pengajuan);
            abort_unless($p->status === 'menunggu', 422, 'Pengajuan sudah diproses.');

            $stok = StokAyam::where('id_periode', $p->id_periode)->lockForUpdate()->firstOrFail();
            if ($d['jumlah_diambil'] > $stok->jumlah_tersedia) {
                throw ValidationException::withMessages(['jumlah_diambil' => "Stok tersedia hanya {$stok->jumlah_tersedia} ekor."]);
            }

            $stok->update(['jumlah_tersedia' => $stok->jumlah_tersedia - $d['jumlah_diambil'], 'tgl_update' => now()]);
            Transaksi::create([
                'id_pengajuan' => $p->id_pengajuan, 'jumlah_diambil' => $d['jumlah_diambil'],
                'total_harga' => $d['jumlah_diambil'] * $d['harga_per_ekor'], 'tgl_transaksi' => $d['tgl_transaksi'],
            ]);
            $p->update(['status' => 'disetujui']);
        });
        return redirect()->route('admin.transaksi.index')->with('ok', 'Transaksi diproses, stok berkurang otomatis');
    }
}
