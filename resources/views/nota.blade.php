<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nota {{ $t->kode }} · TernakKu</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  *{box-sizing:border-box;margin:0}
  body{font:14px/1.5 'Hanken Grotesk',sans-serif;color:#191C1A;background:#F6F8F5;padding:24px}
  .bar{max-width:720px;margin:0 auto 16px;display:flex;gap:10px;justify-content:flex-end}
  .btn{padding:10px 20px;border-radius:999px;border:0;background:#1B4332;color:#fff;font:600 14px 'Hanken Grotesk';cursor:pointer;text-decoration:none}
  .btn.ghost{background:transparent;color:#1B4332;box-shadow:inset 0 0 0 1.5px #1B4332}
  .nota{max-width:720px;margin:auto;background:#fff;border:1px solid #E2E6DF;border-radius:16px;padding:32px}
  .top{display:flex;justify-content:space-between;gap:16px;align-items:flex-start;border-bottom:2px solid #1B4332;padding-bottom:16px;margin-bottom:20px}
  .brand{font:700 22px 'Space Grotesk';color:#1B4332}
  .top small{display:block;color:#5E6360}
  h1{font:700 18px 'Space Grotesk';text-align:right}
  dl{display:grid;grid-template-columns:150px 1fr;gap:6px 16px;margin-bottom:20px}
  dt{color:#5E6360}
  table{width:100%;border-collapse:collapse;margin-bottom:20px}
  th,td{padding:8px 10px;text-align:left;border-bottom:1px solid #E2E6DF}
  th{background:#F0F2EE;font-size:12px;text-transform:uppercase;letter-spacing:.04em}
  .r{text-align:right}.total td{font-weight:700;border-bottom:0}
  .foot{display:flex;justify-content:space-between;align-items:center;gap:16px;border-top:1px dashed #D3D9CE;padding-top:16px}
  .qr svg{width:130px;height:130px;display:block}
  .qr small{display:block;color:#5E6360;max-width:30ch}
  .tag{display:inline-block;padding:2px 10px;border-radius:999px;font-weight:600;font-size:12px;background:#ECFDF5;color:#065F46}
  .tag.w{background:#FFFBEB;color:#92400E}
  @media print{body{background:#fff;padding:0}.bar{display:none}.nota{border:0;border-radius:0;padding:0}}
</style>
</head>
<body>
<div class="bar">
  <a class="btn ghost" href="javascript:history.back()">Kembali</a>
  <button class="btn" type="button" onclick="window.print()">Cetak / Simpan PDF</button>
</div>

<article class="nota">
  <div class="top">
    <div><div class="brand">TernakKu</div><small>Manajemen peternakan dan kemitraan ayam</small></div>
    <div><h1>NOTA PENGAMBILAN</h1><small style="text-align:right">{{ $t->kode }}</small></div>
  </div>

  <dl>
    <dt>Mitra</dt><dd><b>{{ $t->pengajuan->mitra->nama_perusahaan }}</b></dd>
    <dt>Pengajuan</dt><dd>{{ $t->pengajuan->kode }} · {{ $t->pengajuan->periode->nama_periode }}</dd>
    <dt>Tanggal transaksi</dt><dd>{{ $t->tgl_transaksi->translatedFormat('j F Y') }}</dd>
    <dt>Pengambilan</dt><dd><span class="tag {{ $t->diambil_pada ? '' : 'w' }}">{{ $t->diambil_pada ? 'Sudah diambil '.$t->diambil_pada->translatedFormat('j M Y, H:i') : 'Belum diambil' }}</span></dd>
  </dl>

  <table>
    <thead><tr><th>Uraian</th><th class="r">Jumlah</th><th class="r">Harga</th></tr></thead>
    <tbody>
      <tr><td>Ayam hidup</td><td class="r">{{ number_format($t->jumlah_diambil,0,',','.') }} ekor</td><td class="r">Rp {{ number_format($t->total_harga,0,',','.') }}</td></tr>
      @foreach ($t->pembayaran as $b)
        <tr><td class="sub">Pembayaran {{ $b->tgl_bayar->translatedFormat('j M Y') }} · {{ $b->metode }} ({{ $b->status }})</td><td></td><td class="r">{{ $b->status === 'gagal' ? '-' : '- Rp '.number_format($b->jumlah_bayar,0,',','.') }}</td></tr>
      @endforeach
      <tr class="total"><td colspan="2">Sisa tagihan</td><td class="r">Rp {{ number_format($t->sisa,0,',','.') }}</td></tr>
    </tbody>
  </table>

  <div class="foot">
    <div>Status pembayaran: <b>{{ ucfirst($t->status_bayar) }}</b></div>
    <div class="qr">
      @if ($qr){!! $qr !!}@endif
      <small>{{ $qr ? 'Tunjukkan QR ini kepada admin saat pengambilan ayam.' : 'QR belum aktif: jalankan composer require simplesoftwareio/simple-qrcode.' }}</small>
    </div>
  </div>
</article>
</body>
</html>
