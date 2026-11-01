<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Mitra, PengajuanPengambilan, PeriodePemeliharaan};
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $r)
    {
        $status = $r->query('status', '');
        $list = PengajuanPengambilan::with('mitra', 'periode', 'transaksi.pembayaran')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('id_pengajuan')->paginate(10)->withQueryString();
        $count = PengajuanPengambilan::selectRaw('status s, count(*) n')->groupBy('status')->pluck('n', 's');

        return view('admin.pengajuan.index', [
            'list' => $list, 'status' => $status, 'count' => $count, 'total' => $count->sum(),
            'mitraSelect' => Mitra::where('status_verifikasi', 'terverifikasi')->orderBy('nama_perusahaan')->get(),
            'periodeSelect' => PeriodePemeliharaan::where('status', 'berjalan')->get(),
        ]);
    }

    public function store(Request $r)
    {
        $d = $r->validate([
            'id_mitra'        => ['required', 'exists:mitra,id_mitra'],
            'id_periode'      => ['required', 'exists:periode_pemeliharaan,id_periode'],
            'jumlah_diminta'  => ['required', 'integer', 'min:1'],
            'tgl_pengambilan' => ['required', 'date', 'after_or_equal:today'],
        ]);
        PengajuanPengambilan::create($d + ['status' => 'menunggu']);
        return back()->with('ok', 'Pengajuan dikirim');
    }

    public function tolak(PengajuanPengambilan $pengajuan)
    {
        abort_unless($pengajuan->status === 'menunggu', 422, 'Pengajuan sudah diproses.');
        $pengajuan->update(['status' => 'ditolak']);
        return back()->with('ok', $pengajuan->kode . ' ditolak');
    }
}
