<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{PeriodePemeliharaan, StokAyam};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodeController extends Controller
{
    public function index()
    {
        $list = PeriodePemeliharaan::with('stok')->withSum('aktivitas as mati', 'mortalitas')->withCount('pengajuan')
            ->orderByDesc('tgl_mulai')->paginate(10);
        return view('admin.periode.index', compact('list'));
    }

    public function store(Request $r)
    {
        $d = $r->validate([
            'nama_periode'     => ['required', 'string', 'max:100'],
            'tgl_mulai'        => ['required', 'date'],
            'tgl_selesai'      => ['required', 'date', 'after:tgl_mulai'],
            'jumlah_awal_ayam' => ['required', 'integer', 'min:1'],
            'status'           => ['required', 'in:direncanakan,berjalan,selesai'],
        ], ['tgl_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.']);

        DB::transaction(function () use ($d) {
            $p = PeriodePemeliharaan::create($d);
            // periode 1:1 stok: stok dibuat bersamaan, terisi penuh sebesar jumlah awal
            StokAyam::create(['id_periode' => $p->id_periode, 'jumlah_tersedia' => $d['jumlah_awal_ayam'], 'tgl_update' => now()]);
        });
        return back()->with('ok', 'Periode disimpan');
    }

    public function update(Request $r, PeriodePemeliharaan $periode)
    {
        $periode->update($r->validate(['status' => ['required', 'in:direncanakan,berjalan,selesai']]));
        return back()->with('ok', 'Status periode diperbarui');
    }
}
