<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StokAyam;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $list = StokAyam::with('periode')->join('periode_pemeliharaan as p', 'p.id_periode', '=', 'stok_ayam.id_periode')
            ->orderByDesc('p.tgl_mulai')->select('stok_ayam.*')->get();
        return view('admin.stok.index', compact('list'));
    }

    /** Penyesuaian manual (mis. setelah hitung ulang kandang). Pengurangan karena transaksi dilakukan otomatis di TransaksiController. */
    public function update(Request $r, StokAyam $stok)
    {
        $d = $r->validate(['jumlah_tersedia' => ['required', 'integer', 'min:0', 'max:' . $stok->periode->jumlah_awal_ayam]],
            ['jumlah_tersedia.max' => 'Stok tidak boleh melebihi jumlah awal periode.']);
        $stok->update($d + ['tgl_update' => now()]);
        return back()->with('ok', 'Stok diperbarui');
    }
}
