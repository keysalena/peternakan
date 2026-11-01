<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login · TernakKu</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --forest:#1B4332; --forest-d:#143326; --leaf:#2D6A4F; --mint:#A5D0B9; --sage:#DCEBE2;
    --cream:#EFE6D8; --clay:#A27B5C; --paper:#F6F8F5; --ink:#191C1A;
  }
  *{box-sizing:border-box;margin:0}
  body{
    min-height:100vh;display:grid;place-items:center;padding:24px;
    font:15px/1.5 'Hanken Grotesk',system-ui,sans-serif;color:#fff;
    background:
      radial-gradient(circle at 12% 18%,rgba(165,208,185,.16) 0 70px,transparent 71px),
      radial-gradient(circle at 88% 82%,rgba(165,208,185,.12) 0 110px,transparent 111px),
      radial-gradient(circle at 70% 8%,rgba(165,208,185,.10) 0 50px,transparent 51px),
      linear-gradient(160deg,var(--forest) 0%,var(--forest-d) 100%);
  }

  /* ---- kartu utama ---- */
  .shell{
    position:relative;display:grid;grid-template-columns:1.2fr 1fr;
    width:min(1000px,100%);min-height:580px;border-radius:36px;overflow:hidden;
    background:linear-gradient(160deg,#245a43 0%,var(--forest) 100%);
    box-shadow:0 30px 80px rgba(0,0,0,.35);
  }
  .blob{position:absolute;inset:0 auto 0 0;width:64%;height:100%;z-index:0}
  .left,.right{position:relative;z-index:1}

  /* ---- panel kiri ---- */
  .left{display:flex;flex-direction:column;padding:28px 32px;color:var(--forest)}
  .brand{display:flex;align-items:center;gap:10px;font:700 20px 'Space Grotesk',sans-serif}
  .brand i{width:34px;height:34px;border-radius:11px;background:var(--forest);display:grid;place-items:center}
  .art{flex:1;display:grid;place-items:center;padding:8px 0}
  .art svg{width:min(400px,86%);height:auto}
  .left small{font-size:12px;color:#4d5a53}

  /* ---- panel kanan ---- */
  .right{display:flex;flex-direction:column;justify-content:center;padding:40px clamp(28px,5vw,64px)}
  h1{font:700 40px/1.1 'Space Grotesk',sans-serif;margin-bottom:28px}
  form{display:grid;gap:16px}
  label{display:grid;gap:6px;font-weight:500}
  input[type=text],input[type=password]{
    width:100%;padding:13px 18px;border-radius:999px;border:1px solid transparent;
    background:rgba(0,0,0,.28);color:#fff;font:400 15px 'Hanken Grotesk',sans-serif;
  }
  input::placeholder{color:rgba(255,255,255,.6)}
  input:focus-visible{outline:2px solid var(--cream);outline-offset:2px}
  input[aria-invalid=true]{border-color:#FFB4A8}
  .check{display:flex;align-items:center;gap:8px;font-weight:400;color:var(--mint)}
  .check input{width:16px;height:16px;accent-color:var(--cream)}
  .err{color:#FFB4A8;font-size:13px}
  button{
    margin-top:4px;padding:13px 20px;border:0;border-radius:999px;cursor:pointer;
    background:var(--cream);color:var(--forest);font:600 15px 'Hanken Grotesk',sans-serif;
    transition:background .2s,transform .15s;
  }
  button:hover{background:#fff}
  button:active{transform:scale(.98)}
  button:focus-visible{outline:2px solid #fff;outline-offset:3px}
  .note{margin-top:28px;text-align:center;font-size:13px;color:var(--mint)}
  .note a{color:var(--cream);font-weight:600}
  .ok{background:rgba(0,0,0,.22);color:var(--cream);font-size:13px;padding:10px 14px;border-radius:14px}
  .foot{margin-top:auto;padding-top:28px;text-align:right;font-size:12px;color:var(--mint)}

  /* ---- layar kecil ---- */
  @media (max-width:820px){
    .shell{grid-template-columns:1fr;min-height:0}
    .blob,.left{display:none}
    .right{padding:40px 28px 28px}
    .m-brand{display:flex}
  }
  .m-brand{display:none;align-items:center;gap:10px;margin-bottom:24px;font:700 20px 'Space Grotesk',sans-serif}
  .m-brand i{width:34px;height:34px;border-radius:11px;background:var(--cream);display:grid;place-items:center}
</style>
</head>
<body>
<div class="shell">

  {{-- bentuk putih organik di belakang panel kiri --}}
  <svg class="blob" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0 0H64C76 22 52 42 66 62C76 76 62 90 57 100H0Z" fill="#F6F8F5"/>
  </svg>

  {{-- ===== kiri: ilustrasi peternakan ayam ===== --}}
  <section class="left" aria-hidden="true">
    <div class="brand">
      <i><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EFE6D8" stroke-width="2"><path d="M12 3c-3.5 0-6 4.5-6 9a6 6 0 0 0 12 0c0-4.5-2.5-9-6-9z"/></svg></i>
      TernakKu
    </div>

    <div class="art">
      @include('partials.ilustrasi-peternakan')
    </div>

    <small>© 2026 TernakKu · Manajemen peternakan dan kemitraan ayam</small>
  </section>

  {{-- ===== kanan: form login ===== --}}
  <section class="right">
    <div class="m-brand"><i><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><path d="M12 3c-3.5 0-6 4.5-6 9a6 6 0 0 0 12 0c0-4.5-2.5-9-6-9z"/></svg></i>TernakKu</div>
    <h1>Login</h1>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <label>Username
        <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus autocomplete="username" @error('username') aria-invalid="true" @enderror>
      </label>
      <label>Password
        <input type="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
      </label>
      <label class="check"><input type="checkbox" name="remember" value="1" @checked(old('remember'))>Ingat saya di perangkat ini</label>

      @if (session('ok'))<div class="ok" role="status">{{ session('ok') }}</div>@endif
      @if ($errors->any())<div class="err" role="alert">{{ $errors->first() }}</div>@endif
      <button type="submit">Masuk</button>
    </form>

    <p class="note">Belum punya akun? <a href="{{ route('landing') }}#daftar">Daftar sebagai mitra</a></p>
    <div class="foot">Ada kendala? Hubungi tim operasional</div>
  </section>
</div>
</body>
</html>
