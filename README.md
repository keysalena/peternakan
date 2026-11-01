# TernakKu — dashboard admin (Laravel 11+)

Hasil pemisahan `dashboard-peternakan-v2.html` menjadi struktur Laravel, lengkap dengan data sesuai ERD proposal.
Folder ini hanya berisi file yang ditambahkan ke project Laravel baru. Salin isinya ke root project.

## Struktur
| Bagian | Lokasi |
|---|---|
| CSS | `public/css/dashboard.css` |
| JS (tema, sidebar, modal, toast, perilaku kecil) | `public/js/*.js` |
| Layout, sidebar, navigasi mobile, topbar, toast, ikon | `resources/views/layouts`, `resources/views/partials` |
| Komponen (modal, badge, stat, judul halaman) | `resources/views/components` |
| Form modal | `resources/views/modals` |
| Halaman | `resources/views/admin/{dashboard,mitra,periode,aktivitas,stok,pengajuan,transaksi,pembayaran}` |
| Migration (8 tabel ERD) | `database/migrations` |
| Model, controller, middleware | `app/Models`, `app/Http/Controllers/Admin`, `app/Http/Middleware/EnsureAdmin.php` |
| Data contoh | `database/seeders/DatabaseSeeder.php` |

## Pemasangan
```bash
composer create-project laravel/laravel ternakku && cd ternakku
# salin seluruh isi folder ini ke dalam project (timpa routes/web.php dan DatabaseSeeder.php)
rm database/migrations/0001_01_01_000000_create_users_table.php   # diganti migration users versi ERD
composer require laravel/breeze --dev && php artisan breeze:install blade   # login dan logout
```
1. Di `.env` atur database MySQL dan `SESSION_DRIVER=file` (tabel `sessions` bawaan ikut terhapus bersama migration lama).
2. Breeze secara bawaan login memakai email. ERD memakai `username`: ganti field `email` menjadi `username` pada
   `LoginRequest` dan `resources/views/auth/login.blade.php`, serta hapus validasi/field email di bagian registrasi.
3. `php artisan migrate --seed` lalu `php artisan serve`.
4. Login: `admin` / `password`. Mitra contoh memakai password `password`.

## Pemetaan ERD
`users 1:1 mitra`, `mitra 1:N pengajuan_pengambilan`, `periode_pemeliharaan 1:N pengajuan_pengambilan`,
`periode 1:N aktivitas_pemeliharaan`, `periode 1:1 stok_ayam`, `pengajuan 1:1 transaksi`, `transaksi 1:N pembayaran`.
Nama tabel, kolom, dan primary key mengikuti ERD (`id_user`, `id_mitra`, dan seterusnya).

## Aturan bisnis yang sudah diterapkan
- **Memproses pengajuan** (`TransaksiController@store`): dalam satu `DB::transaction` dengan row lock, stok periode dikurangi,
  transaksi dibuat, dan pengajuan menjadi `disetujui`. Jumlah diambil tidak boleh melebihi jumlah diminta maupun stok tersedia.
- **Periode baru** otomatis membuat baris `stok_ayam` sebesar jumlah awal.
- **Pembayaran** tidak boleh melebihi sisa tagihan. Status bayar transaksi (lunas/cicilan/belum bayar) dihitung dari pembayaran non-gagal.
- Mitra baru dibuat sebagai akun `users` (role mitra) + profil `mitra` berstatus `menunggu`.

## Perbedaan dari HTML asli
- Filter chip "Kandang A/B" dihapus karena tidak ada di ERD.
- Pencarian dan filter mitra kini dilakukan server (query string), bukan array JS.
- `pengajuan_pengambilan` diberi `created_at/updated_at` (di luar ERD) untuk grafik 7 hari terakhir.
- Ditambah halaman Aktivitas dan Pembayaran agar ke-8 tabel ERD punya halaman.
- Mortalitas tidak otomatis mengurangi stok (sesuai proposal, hanya transaksi yang mengurangi). Selisih bisa disesuaikan di halaman Stok.
