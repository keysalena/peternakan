<?php
namespace Database\Seeders;

use App\Models\{AktivitasPemeliharaan, Mitra, Pembayaran, PengajuanPengambilan, PeriodePemeliharaan, StokAyam, Transaksi, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['username' => 'admin', 'password' => 'password', 'role' => 'admin']);

        // --- Mitra (akun pengguna + profil perusahaan) ---
        $daftar = [
            ['PT Berkah Sentosa', 'PT', 'Malang',   '0812-3456-7801', 'terverifikasi'],
            ['CV Maju Jaya',      'CV', 'Batu',     '0813-2200-4412', 'menunggu'],
            ['CV Tani Lestari',   'CV', 'Kediri',   '0857-9012-3345', 'terverifikasi'],
            ['PT Sumber Makmur',  'PT', 'Blitar',   '0821-7788-9001', 'ditolak'],
            ['PT Agro Nusantara', 'PT', 'Surabaya', '0811-5566-2290', 'terverifikasi'],
            ['CV Ternak Mandiri', 'CV', 'Pasuruan', '0852-3341-8870', 'menunggu'],
            ['PT Unggas Prima',   'PT', 'Jombang',  '0878-4410-6623', 'terverifikasi'],
        ];
        $mitra = [];
        foreach ($daftar as [$nama, $bentuk, $alamat, $kontak, $status]) {
            $user = User::create(['username' => str($nama)->slug('_')->toString(), 'password' => 'password', 'role' => 'mitra']);
            $mitra[$nama] = Mitra::create([
                'id_user' => $user->id_user, 'nama_perusahaan' => $nama, 'bentuk_usaha' => $bentuk,
                'alamat' => $alamat, 'kontak' => $kontak, 'status_verifikasi' => $status,
            ]);
        }

        // --- Periode, stok (1:1), aktivitas (1:N) ---
        $p11 = PeriodePemeliharaan::create(['nama_periode' => 'Periode 11', 'tgl_mulai' => '2026-08-15', 'tgl_selesai' => '2026-09-26', 'jumlah_awal_ayam' => 9500, 'status' => 'selesai']);
        $p12 = PeriodePemeliharaan::create(['nama_periode' => 'Periode 12', 'tgl_mulai' => '2026-10-01', 'tgl_selesai' => '2026-11-12', 'jumlah_awal_ayam' => 10800, 'status' => 'berjalan']);
        StokAyam::create(['id_periode' => $p11->id_periode, 'jumlah_tersedia' => 0,    'tgl_update' => '2026-09-26 16:00:00']);
        StokAyam::create(['id_periode' => $p12->id_periode, 'jumlah_tersedia' => 8420, 'tgl_update' => '2026-10-25 08:10:00']);

        foreach ([
            ['2026-10-10', 'Pemeriksaan kesehatan', 120, 'Kandang B'],
            ['2026-10-17', 'Pemeriksaan kesehatan', 71,  'Kandang A'],
            ['2026-10-22', 'Penimbangan mingguan',  0,   'Rata-rata 1,6 kg'],
            ['2026-10-23', 'Mortalitas naik',       14,  'Kandang B'],
            ['2026-10-24', 'Pakan hampir habis',    0,   'Silo 2 tersisa 12%'],
            ['2026-10-25', 'Vaksinasi ND-IB',       0,   'Kandang A'],
        ] as [$tgl, $jenis, $mati, $cat]) {
            AktivitasPemeliharaan::create(['id_periode' => $p12->id_periode, 'tanggal' => $tgl, 'jenis_aktivitas' => $jenis, 'mortalitas' => $mati, 'catatan' => $cat]);
        }

        // --- Pengajuan -> transaksi (1:1) -> pembayaran (1:N) ---
        $hari = fn (int $n) => now()->subDays($n);
        $buat = function (string $mitraNama, int $jumlah, string $status, int $umurHari, ?array $trx = null, array $bayar = []) use ($mitra, $p12, $hari) {
            $pgj = PengajuanPengambilan::create([
                'id_mitra' => $mitra[$mitraNama]->id_mitra, 'id_periode' => $p12->id_periode, 'jumlah_diminta' => $jumlah,
                'tgl_pengambilan' => $hari($umurHari)->addDays(5)->toDateString(), 'status' => $status,
                'created_at' => $hari($umurHari), 'updated_at' => $hari($umurHari),
            ]);
            if ($trx) {
                $t = Transaksi::create(['id_pengajuan' => $pgj->id_pengajuan, 'jumlah_diambil' => $trx[0], 'total_harga' => $trx[0] * 7000, 'tgl_transaksi' => $hari($umurHari)->toDateString()]);
                foreach ($bayar as [$nominal, $metode, $st]) {
                    Pembayaran::create(['id_transaksi' => $t->id_transaksi, 'jumlah_bayar' => $nominal, 'metode' => $metode, 'status' => $st, 'tgl_bayar' => $hari($umurHari)->toDateString()]);
                }
            }
        };
        $buat('PT Agro Nusantara', 900,  'disetujui', 6, [900],  [[6300000, 'Transfer bank', 'lunas']]);
        $buat('PT Unggas Prima',   700,  'disetujui', 5, [700],  [[4900000, 'Transfer bank', 'lunas']]);
        $buat('PT Berkah Sentosa', 1200, 'disetujui', 4, [1200], [[8400000, 'Transfer bank', 'lunas']]);
        $buat('CV Tani Lestari',   1500, 'disetujui', 3, [1500], [[5000000, 'Transfer bank', 'cicilan']]);
        $buat('PT Sumber Makmur',  2000, 'ditolak',   2);
        $buat('CV Maju Jaya',      800,  'menunggu',  1);
        $buat('CV Tani Lestari',   600,  'menunggu',  0);
    }
}
