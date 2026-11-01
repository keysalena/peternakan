<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TernakKu · Kemitraan peternakan ayam</title>
<meta name="description" content="Daftar sebagai mitra peternakan ayam, ajukan pengambilan, dan pantau transaksi serta pembayaran dalam satu tempat.">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

<header class="nav">
  <div class="wrap">
    <a class="brand" href="{{ route('landing') }}"><i><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EFE6D8" stroke-width="2"><path d="M12 3c-3.5 0-6 4.5-6 9a6 6 0 0 0 12 0c0-4.5-2.5-9-6-9z"/></svg></i>TernakKu</a>
    <a class="l" href="#info">Informasi</a>
    <a class="l" href="#cara">Cara kerja</a>
    <a class="l" href="#daftar">Daftar mitra</a>
    @auth
      <a class="btn sm" href="{{ auth()->user()->homeUrl() }}">Ke dashboard</a>
    @else
      <a class="btn sm" href="{{ route('login') }}">Login</a>
    @endauth
  </div>
</header>

<main>
  <section class="hero">
    <div class="wrap">
      <div>
        <span class="eyebrow">Kemitraan peternakan ayam</span>
        <h1>Dari kandang sampai pembayaran, semuanya tercatat jelas.</h1>
        <p class="lead">Daftar sebagai mitra, ajukan pengambilan ayam, lalu pantau stok, transaksi, dan pembayaran Anda dari satu dashboard.</p>
        <div class="cta">
          <a class="btn" href="#daftar">Daftar jadi mitra</a>
          <a class="btn ghost" href="{{ route('login') }}">Sudah punya akun</a>
        </div>
      </div>
      <div class="art" aria-hidden="true">@include('partials.ilustrasi-peternakan')</div>
    </div>
  </section>

  <section class="info" id="info">
    <div class="wrap cards">
      <div class="c"><small>Periode berjalan</small><b>{{ $periode->nama_periode ?? 'Belum ada' }}</b><span>{{ $periode ? $periode->rentang : 'Periode berikutnya segera dibuka' }}</span></div>
      <div class="c"><small>Stok ayam tersedia</small><b>{{ number_format($stok,0,',','.') }} ekor</b><span>Diperbarui otomatis setiap ada transaksi</span></div>
      <div class="c"><small>Mitra terverifikasi</small><b>{{ $mitraAktif }}</b><span>Perusahaan yang sudah bergabung</span></div>
    </div>
  </section>

  <section class="how" id="cara">
    <div class="wrap">
      <h2>Cara menjadi mitra</h2>
      <p class="sub">Empat langkah dari pendaftaran sampai pembayaran.</p>
      <ol class="steps">
        <li><em>1</em><h3>Daftar</h3><p>Isi data perusahaan dan buat akun di formulir di bawah.</p></li>
        <li><em>2</em><h3>Verifikasi</h3><p>Admin memeriksa data Anda. Anda dapat login, tetapi pengajuan baru terbuka setelah akun diverifikasi.</p></li>
        <li><em>3</em><h3>Ajukan pengambilan</h3><p>Pilih jumlah ayam dan tanggal ambil sesuai stok yang tersedia.</p></li>
        <li><em>4</em><h3>Pantau</h3><p>Lihat status pengajuan, riwayat transaksi, dan informasi pembayaran.</p></li>
      </ol>
    </div>
  </section>

  <section class="reg" id="daftar">
    <div class="wrap">
      <div>
        <h2>Daftar sebagai mitra</h2>
        <p>Isi formulir berikut. Setelah terdaftar, Anda dapat login dan melihat dashboard mitra. Pengajuan pengambilan dibuka setelah admin memverifikasi akun.</p>
        <ul><li>Data perusahaan (PT atau CV)</li><li>Kontak yang dapat dihubungi</li><li>Username dan password untuk login</li></ul>
      </div>

      <form class="form" method="POST" action="{{ route('daftar') }}">
        @csrf
        <label>Nama perusahaan
          <input name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required autocomplete="organization" placeholder="PT Contoh Makmur" @error('nama_perusahaan') aria-invalid="true" @enderror>
          @error('nama_perusahaan')<span class="err">{{ $message }}</span>@enderror
        </label>
        <div class="f2">
          <label>Bentuk usaha
            <select name="bentuk_usaha"><option>PT</option><option @selected(old('bentuk_usaha') === 'CV')>CV</option></select>
          </label>
          <label>Kontak
            <input name="kontak" value="{{ old('kontak') }}" required autocomplete="tel" placeholder="0812-0000-0000" @error('kontak') aria-invalid="true" @enderror>
            @error('kontak')<span class="err">{{ $message }}</span>@enderror
          </label>
        </div>
        <label>Alamat
          <input name="alamat" value="{{ old('alamat') }}" required autocomplete="street-address" placeholder="Kota, kecamatan" @error('alamat') aria-invalid="true" @enderror>
          @error('alamat')<span class="err">{{ $message }}</span>@enderror
        </label>
        <label>Username
          <input name="username" value="{{ old('username') }}" required autocomplete="username" @error('username') aria-invalid="true" @enderror>
          @error('username')<span class="err">{{ $message }}</span>@enderror
        </label>
        <div class="f2">
          <label>Password
            <input type="password" name="password" minlength="6" required autocomplete="new-password" @error('password') aria-invalid="true" @enderror>
            @error('password')<span class="err">{{ $message }}</span>@enderror
          </label>
          <label>Ulangi password
            <input type="password" name="password_confirmation" minlength="6" required autocomplete="new-password">
          </label>
        </div>
        <button class="btn" type="submit">Daftar</button>
        <p class="alt">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
      </form>
    </div>
  </section>
</main>

<footer><div class="wrap">© 2026 TernakKu · Manajemen peternakan dan kemitraan ayam</div></footer>
</body>
</html>
