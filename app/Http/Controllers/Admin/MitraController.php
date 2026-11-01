<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Mitra, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MitraController extends Controller
{
    public function index(Request $r)
    {
        $status = $r->query('status', '');
        $q = trim($r->query('q', ''));
        $list = Mitra::withCount('pengajuan')
            ->when($status, fn ($x) => $x->where('status_verifikasi', $status))
            ->when($q, fn ($x) => $x->where(fn ($w) => $w->where('nama_perusahaan', 'like', "%$q%")->orWhere('alamat', 'like', "%$q%")))
            ->orderByDesc('id_mitra')->paginate(10)->withQueryString();

        $count = Mitra::selectRaw('status_verifikasi s, count(*) n')->groupBy('status_verifikasi')->pluck('n', 's');
        return view('admin.mitra.index', compact('list', 'status', 'q') + ['count' => $count, 'total' => $count->sum()]);
    }

    public function store(Request $r)
    {
        $d = $r->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'bentuk_usaha'    => ['required', 'in:PT,CV'],
            'kontak'          => ['required', 'string', 'max:30'],
            'alamat'          => ['required', 'string', 'max:255'],
            'username'        => ['required', 'string', 'max:50', 'unique:users,username'],
            'password'        => ['required', 'string', 'min:6'],
        ]);
        DB::transaction(function () use ($d) {
            $u = User::create(['username' => $d['username'], 'password' => $d['password'], 'role' => 'mitra']);
            Mitra::create([
                'id_user' => $u->id_user, 'nama_perusahaan' => $d['nama_perusahaan'], 'bentuk_usaha' => $d['bentuk_usaha'],
                'alamat' => $d['alamat'], 'kontak' => $d['kontak'], 'status_verifikasi' => 'menunggu',
            ]);
        });
        return back()->with('ok', 'Mitra ditambahkan');
    }

    public function verifikasi(Request $r, Mitra $mitra)
    {
        $d = $r->validate(['status_verifikasi' => ['required', 'in:terverifikasi,ditolak']]);
        $mitra->update($d);
        return back()->with('ok', $mitra->nama_perusahaan . ($d['status_verifikasi'] === 'terverifikasi' ? ' diverifikasi' : ' ditolak'));
    }
}
