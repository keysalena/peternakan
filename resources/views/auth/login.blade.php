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
      <svg viewBox="0 0 400 330" role="img" aria-label="Ilustrasi kandang dan ayam di peternakan">
        <defs><clipPath id="scene"><circle cx="200" cy="165" r="150"/></clipPath></defs>
        <circle cx="200" cy="165" r="150" fill="#DCEBE2"/>
        <g clip-path="url(#scene)"><g transform="translate(0 -24)">
          <circle cx="280" cy="100" r="24" fill="#E9C46A"/>
          <ellipse cx="120" cy="290" rx="180" ry="80" fill="#86AF99"/>
          <ellipse cx="300" cy="312" rx="200" ry="84" fill="#2D6A4F"/>
          <!-- kandang -->
          <rect x="92" y="182" width="116" height="72" fill="#A27B5C"/>
          <polygon points="82,185 150,132 218,185" fill="#1B4332"/>
          <rect x="132" y="212" width="36" height="42" fill="#EFE6D8"/>
          <path d="M132 212L168 254M168 212L132 254" stroke="#A27B5C" stroke-width="3"/>
          <circle cx="150" cy="166" r="7" fill="#EFE6D8"/>
          <!-- pagar -->
          <g fill="#EFE6D8" stroke="#1B4332" stroke-width="1.5">
            <rect x="236" y="232" width="8" height="40"/><rect x="262" y="232" width="8" height="40"/>
            <rect x="288" y="232" width="8" height="40"/><rect x="314" y="232" width="8" height="40"/>
            <rect x="230" y="242" width="98" height="6"/><rect x="230" y="258" width="98" height="6"/>
          </g>
          <!-- ayam putih -->
          <g transform="translate(205 270)">
            <path d="M-26 -14C-38 -22 -38 -2 -24 0Z" fill="#EFE6D8" stroke="#1B4332" stroke-width="2"/>
            <ellipse cx="0" cy="0" rx="26" ry="19" fill="#EFE6D8" stroke="#1B4332" stroke-width="2"/>
            <circle cx="20" cy="-18" r="10" fill="#EFE6D8" stroke="#1B4332" stroke-width="2"/>
            <path d="M15 -29q5 -8 10 -2q5 -6 6 2Z" fill="#C8553D"/>
            <path d="M29 -18l9 3l-9 4Z" fill="#E9A23B"/>
            <circle cx="23" cy="-20" r="1.8" fill="#1B4332"/>
            <path d="M-6 3q10 8 20 -2" fill="none" stroke="#1B4332" stroke-width="2"/>
            <path d="M-6 19v10M6 19v10M-10 29h8M2 29h8" stroke="#E9A23B" stroke-width="3" fill="none" stroke-linecap="round"/>
          </g>
          <!-- ayam cokelat -->
          <g transform="translate(120 292) scale(.8)">
            <path d="M-26 -14C-38 -22 -38 -2 -24 0Z" fill="#7A5A41" stroke="#1B4332" stroke-width="2"/>
            <ellipse cx="0" cy="0" rx="26" ry="19" fill="#A27B5C" stroke="#1B4332" stroke-width="2"/>
            <circle cx="20" cy="-18" r="10" fill="#A27B5C" stroke="#1B4332" stroke-width="2"/>
            <path d="M15 -29q5 -8 10 -2q5 -6 6 2Z" fill="#C8553D"/>
            <path d="M29 -18l9 3l-9 4Z" fill="#E9A23B"/>
            <circle cx="23" cy="-20" r="1.8" fill="#1B4332"/>
            <path d="M-6 3q10 8 20 -2" fill="none" stroke="#1B4332" stroke-width="2"/>
            <path d="M-6 19v10M6 19v10M-10 29h8M2 29h8" stroke="#E9A23B" stroke-width="3" fill="none" stroke-linecap="round"/>
          </g>
          <!-- anak ayam dan telur -->
          <circle cx="258" cy="298" r="9" fill="#E9C46A"/><path d="M266 297l6 2l-6 2Z" fill="#E9A23B"/>
          <circle cx="260" cy="296" r="1.4" fill="#1B4332"/>
          <ellipse cx="170" cy="306" rx="7" ry="9" fill="#EFE6D8" stroke="#1B4332" stroke-width="1.5"/>
          <ellipse cx="184" cy="310" rx="7" ry="9" fill="#EFE6D8" stroke="#1B4332" stroke-width="1.5"/>
        </g></g>
      </svg>
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

      @if ($errors->any())<div class="err" role="alert">{{ $errors->first() }}</div>@endif
      <button type="submit">Masuk</button>
    </form>

    <p class="note">Akun dibuat oleh admin. Belum punya akun? Hubungi tim operasional.</p>
    <div class="foot">Ada kendala? Hubungi tim operasional</div>
  </section>
</div>
</body>
</html>