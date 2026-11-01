@extends('layouts.admin')
@section('title', 'Dashboard mitra')
@section('content')
<x-page-title :title="$mitra->nama_perusahaan" :sub="$mitra->kode.' · '.$mitra->bentuk_usaha.' · '.$mitra->alamat">
  <a class="btn" href="{{ route('mitra.pengajuan.index') }}"><svg class="ic"><use href="#i-plus"/></svg>Ajukan pengambilan</a>
</x-page-title>

@if ($mitra->status_verifikasi !== 'terverifikasi')
  <section class="card" style="margin-bottom:16px;border-left:4px solid var(--{{ $mitra->status_verifikasi === 'ditolak' ? 'c' : 'w' }},#B7791F)">
    <b>{{ $mitra->status_verifikasi === 'ditolak' ? 'Pendaftaran ditolak' : 'Menunggu verifikasi admin' }}</b>
    <div class="sub">{{ $mitra->status_verifikasi === 'ditolak' ? 'Hubungi tim operasional untuk informasi lebih lanjut.' : 'Anda dapat mengajukan pengambilan ayam setelah akun diverifikasi.' }}</div>
  </section>
@endif

<div class="grid">
  <x-stat icon="box" label="Stok tersedia" :value="number_format($stok,0,',','.')" unit="ekor" tone="ok" badge="saat ini" :bar="$persenStok"/>
  <x-stat icon="clip" label="Pengajuan menunggu" :value="$menunggu" unit="pengajuan" tone="w" badge="diproses"/>
  <x-stat icon="egg" label="Total ayam diambil" :value="number_format($diambil,0,',','.')" unit="ekor"/>
  <x-stat icon="card" label="Sisa tagihan" :value="'Rp '.number_format($sisa/1000000,1,',','.')" unit="juta" :tone="$sisa > 0 ? 'c' : 'ok'" :badge="$sisa > 0 ? 'belum lunas' : 'lunas'"/>

  <section class="card tbl" style="grid-column:span 8">
    <div class="head"><h2>Pengajuan terbaru</h2><a class="btn ghost sm" href="{{ route('mitra.pengajuan.index') }}">Lihat semua</a></div>
    <div class="scroll"><table>
      <thead><tr><th>ID</th><th>Diminta</th><th>Tgl ambil</th><th>Pengajuan</th><th>Bayar</th></tr></thead>
      <tbody>
        @forelse ($pengajuan as $p)
          <tr><td class="mono">{{ $p->kode }}</td><td class="mono">{{ number_format($p->jumlah_diminta,0,',','.') }}</td>
            <td class="mono">{{ $p->tgl_pengambilan->translatedFormat('j M Y') }}</td><td><x-badge :s="$p->status"/></td>
            <td>@if ($p->transaksi)<x-badge :s="$p->transaksi->status_bayar"/>@else<span class="sub">-</span>@endif</td></tr>
        @empty
          <tr><td colspan="5" class="sub empty">Belum ada pengajuan.</td></tr>
        @endforelse
      </tbody>
    </table></div>
  </section>

  <section class="card side" style="grid-column:span 4">
    <div class="head"><h2 style="color:#fff">{{ $periode->nama_periode ?? 'Tidak ada periode' }}</h2></div>
    <div class="gauge" style="--p:{{ $persenStok }}"><div><span><span class="num">{{ $persenStok }}%</span><small>AYAM TERSISA</small></span></div></div>
    <div class="li"><i><svg class="ic"><use href="#i-cal"/></svg></i><div><b>{{ $periode?->rentang ?? '-' }}</b><span>Rentang periode</span></div></div>
  </section>
</div>
@endsection
