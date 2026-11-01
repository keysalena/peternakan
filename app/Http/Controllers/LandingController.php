<?php
namespace App\Http\Controllers;

use App\Models\{Mitra, PeriodePemeliharaan, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LandingController extends Controller
{
    public function index()
    {
        $periode = PeriodePemeliharaan::with('stok')->berjalan()->latest('tgl_mulai')->first();
        return view('landing', [
            'periode'    => $periode,
            'stok'       => $periode?->stok?->jumlah_tersedia ?? 0,
            'mitraAktif' => Mitra::where('status_verifikasi', 'terverifikasi')->count(),
        ]);
    }

    /** Calon mitra mendaftar: akun users (role mitra) + profil mitra berstatus menunggu verifikasi. */
    public function daftar(Request $r)
    {
        $v = Validator::make($r->all(), [
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'bentuk_usaha'    => ['required', 'in:PT,CV'],
            'kontak'          => ['required', 'string', 'max:30'],
            'alamat'          => ['required', 'string', 'max:255'],
            'username'        => ['required', 'alpha_dash', 'max:50', 'unique:users,username'],
            'password'        => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'username.unique'      => 'Username sudah dipakai, pilih yang lain.',
            'username.alpha_dash'  => 'Username hanya boleh huruf, angka, strip, dan garis bawah.',
            'password.confirmed'   => 'Konfirmasi password tidak sama.',
            'password.min'         => 'Password minimal 6 karakter.',
        ]);
        if ($v->fails()) {
            return redirect(route('landing') . '#daftar')->withErrors($v)->withInput($r->except('password', 'password_confirmation'));
        }

        $d = $v->validated();
        DB::transaction(function () use ($d) {
            $u = User::create(['username' => $d['username'], 'password' => $d['password'], 'role' => 'mitra']);
            Mitra::create([
                'id_user' => $u->id_user, 'nama_perusahaan' => $d['nama_perusahaan'], 'bentuk_usaha' => $d['bentuk_usaha'],
                'alamat' => $d['alamat'], 'kontak' => $d['kontak'], 'status_verifikasi' => 'menunggu',
            ]);
        });

        return redirect()->route('login')->with('ok', 'Pendaftaran berhasil. Akun Anda aktif penuh setelah diverifikasi admin.');
    }
}
