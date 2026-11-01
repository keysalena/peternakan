<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Pembayaran, Transaksi};
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PembayaranController extends Controller
{
    public const METODE = ['Transfer bank', 'Tunai', 'QRIS'];

    public function index(Request $r)
    {
        $status = $r->query('status', '');
        $list = Pembayaran::with('transaksi.pengajuan.mitra')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('id_pembayaran')->paginate(10)->withQueryString();
        $count = Pembayaran::selectRaw('status s, count(*) n')->groupBy('status')->pluck('n', 's');
        $open = Transaksi::with('pengajuan.mitra', 'pembayaran')->get()->filter(fn ($t) => $t->sisa > 0);

        return view('admin.pembayaran.index', ['list' => $list, 'status' => $status, 'count' => $count, 'total' => $count->sum(),
            'openTrx' => $open, 'metode' => self::METODE, 'masuk' => (int) Pembayaran::where('status', '!=', 'gagal')->sum('jumlah_bayar')]);
    }

    public function store(Request $r)
    {
        $d = $r->validate([
            'id_transaksi' => ['required', 'exists:transaksi,id_transaksi'],
            'jumlah_bayar' => ['required', 'integer', 'min:1'],
            'metode'       => ['required', 'in:' . implode(',', self::METODE)],
            'status'       => ['required', 'in:lunas,cicilan,gagal'],
            'tgl_bayar'    => ['required', 'date'],
        ]);
        $trx = Transaksi::with('pembayaran')->findOrFail($d['id_transaksi']);
        if ($d['status'] !== 'gagal' && $d['jumlah_bayar'] > $trx->sisa) {
            throw ValidationException::withMessages(['jumlah_bayar' => 'Jumlah melebihi sisa tagihan (Rp ' . number_format($trx->sisa, 0, ',', '.') . ').']);
        }
        Pembayaran::create($d);
        return back()->with('ok', 'Pembayaran dicatat');
    }
}
