@extends('layouts.admin')
@section('title', 'Konfirmasi pengambilan')
@section('content')
<x-page-title :title="'Konfirmasi pengambilan '.$t->kode" sub="Hasil pindai QR pada nota mitra."/>
<div class="grid"><section class="card full" style="max-width:640px">
  <dl style="display:grid;grid-template-columns:150px 1fr;gap:10px 16px;margin:0 0 20px">
    <dt class="sub">Mitra</dt><dd><b>{{ $t->pengajuan->mitra->nama_perusahaan }}</b></dd>
    <dt class="sub">Pengajuan</dt><dd class="mono">{{ $t->pengajuan->kode }} · {{ $t->pengajuan->periode->nama_periode }}</dd>
    <dt class="sub">Jumlah diambil</dt><dd class="mono">{{ number_format($t->jumlah_diambil,0,',','.') }} ekor</dd>
    <dt class="sub">Total</dt><dd class="mono">Rp {{ number_format($t->total_harga,0,',','.') }}</dd>
    <dt class="sub">Pembayaran</dt><dd><x-badge :s="$t->status_bayar"/>@if ($t->sisa > 0) <span class="sub">sisa Rp {{ number_format($t->sisa,0,',','.') }}</span>@endif</dd>
    <dt class="sub">Pengambilan</dt><dd><x-badge :s="$t->status_ambil"/>@if ($t->diambil_pada) <span class="sub">{{ $t->diambil_pada->translatedFormat('j M Y, H:i') }}</span>@endif</dd>
  </dl>

  @if ($t->diambil_pada)
    <div class="sub">Transaksi ini sudah dikonfirmasi diambil.</div>
  @else
    @if ($t->sisa > 0)<div class="err" style="margin-bottom:12px">Tagihan belum lunas. Pastikan pembayaran sesuai kebijakan sebelum menyerahkan ayam.</div>@endif
    <form method="POST" action="{{ route('admin.transaksi.konfirmasi', $t) }}">@csrf @method('PATCH')
      <button class="btn">Konfirmasi ayam sudah diambil</button>
      <a class="btn ghost" href="{{ route('admin.transaksi.index') }}">Kembali</a>
    </form>
  @endif
</section></div>
@endsection
