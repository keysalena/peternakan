<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{AktivitasPemeliharaan, PeriodePemeliharaan};
use Illuminate\Http\Request;

class AktivitasController extends Controller
{
    public const JENIS = ['Vaksinasi', 'Pemberian pakan', 'Penimbangan mingguan', 'Pemeriksaan kesehatan', 'Pembersihan kandang', 'Lainnya'];

    public function index(Request $r)
    {
        $periodeSelect = PeriodePemeliharaan::orderByDesc('tgl_mulai')->get();
        $idPeriode = $r->query('periode', optional($periodeSelect->firstWhere('status', 'berjalan'))->id_periode);
        $list = AktivitasPemeliharaan::with('periode')
            ->when($idPeriode, fn ($q) => $q->where('id_periode', $idPeriode))
            ->orderByDesc('tanggal')->orderByDesc('id_aktivitas')->paginate(10)->withQueryString();
        $mati = (int) AktivitasPemeliharaan::when($idPeriode, fn ($q) => $q->where('id_periode', $idPeriode))->sum('mortalitas');

        return view('admin.aktivitas.index', ['list' => $list, 'periodeSelect' => $periodeSelect, 'idPeriode' => $idPeriode, 'mati' => $mati, 'jenis' => self::JENIS]);
    }

    public function store(Request $r)
    {
        $d = $r->validate([
            'id_periode'      => ['required', 'exists:periode_pemeliharaan,id_periode'],
            'tanggal'         => ['required', 'date'],
            'jenis_aktivitas' => ['required', 'string', 'max:100'],
            'mortalitas'      => ['nullable', 'integer', 'min:0'],
            'catatan'         => ['nullable', 'string', 'max:500'],
        ]);
        $d['mortalitas'] = $d['mortalitas'] ?? 0;
        AktivitasPemeliharaan::create($d);
        return back()->with('ok', 'Aktivitas dicatat');
    }
}
