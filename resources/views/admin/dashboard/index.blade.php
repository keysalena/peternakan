@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<x-page-title title="Ringkasan peternakan" :sub="$periode ? 'Periode aktif: '.$periode->nama_periode.' · '.$periode->rentang : 'Belum ada periode yang berjalan'">
  <button class="btn" data-open="periode-baru"><svg class="ic"><use href="#i-plus"/></svg>Periode baru</button>
</x-page-title>

<div class="grid">
  <x-stat icon="box" label="Stok ayam" :value="number_format($stok,0,',','.')" unit="ekor" tone="ok" :badge="$persenStok >= 50 ? 'stabil' : 'menipis'" :bar="$persenStok"/>
  <x-stat icon="clip" label="Pengajuan menunggu" :value="$menunggu" unit="pengajuan" tone="w" badge="perlu cek" :bar="$persenMenunggu"/>
  <x-stat icon="users" label="Mitra terverifikasi" :value="$mitraOk" :unit="'dari '.$totalMitra" tone="ok" badge="aktif" :bar="$totalMitra ? round($mitraOk/$totalMitra*100) : 0"/>
  <x-stat icon="card" label="Belum dibayar" :value="'Rp '.number_format($belum/1000000,1,',','.')" unit="juta" tone="c" badge="tertunda" :bar="$persenBelum"/>

  <section class="card chart">
    <div class="head"><h2>Pengajuan pengambilan</h2><span class="badge b-ok">7 hari terakhir</span></div>
    <div class="bars">
      @foreach ($grafik as $g)
        <div @class(['hi' => $g['n'] === $grafik->max('n') && $g['n'] > 0])><em>{{ $g['n'] }}</em><span style="height:{{ max(4, $g['n'] / $maks * 90) }}%"></span></div>
      @endforeach
    </div>
    <div class="days">@foreach ($grafik as $g)<b>{{ $g['hari'] }}</b>@endforeach</div>
  </section>

  <section class="card mitra">
    <div class="head"><h2>Mitra terbaru</h2><a class="btn ghost sm" href="{{ route('admin.mitra.index') }}">Lihat semua</a></div>
    @foreach ($mitraBaru as $m)
      <div class="mrow"><div class="av">{{ $m->inisial }}</div><div><b>{{ $m->nama_perusahaan }}</b><span class="sub">{{ $m->bentuk_usaha }} · {{ $m->alamat }}</span></div><x-badge :s="$m->status_verifikasi"/></div>
    @endforeach
  </section>

  <section class="card side">
    <div class="head"><h2 style="color:#fff">{{ $periode->nama_periode ?? 'Tidak ada periode' }}</h2></div>
    <div class="gauge" style="--p:{{ $persenStok }}"><div><span><span class="num">{{ $persenStok }}%</span><small>AYAM TERSISA</small></span></div></div>
    <div class="li"><i><svg class="ic"><use href="#i-egg"/></svg></i><div><b>{{ number_format($awal,0,',','.') }} ekor</b><span>Jumlah awal</span></div></div>
    <div class="li"><i><svg class="ic"><use href="#i-down"/></svg></i><div><b>{{ str_replace('.', ',', $persenMati) }}%</b><span>Mortalitas</span></div></div>
    <div class="li"><i><svg class="ic"><use href="#i-ref"/></svg></i><div><b>{{ $periode?->stok?->tgl_update?->translatedFormat('j M, H:i') ?? '-' }}</b><span>Stok diperbarui</span></div></div>
    <a class="btn" href="{{ route('admin.stok.index') }}">Lihat detail</a>
  </section>

  <section class="card tbl">
    <div class="head"><h2>Pengajuan &amp; transaksi terbaru</h2>
      <div style="display:flex;gap:8px"><button class="btn sm" data-open="pengajuan-baru"><svg class="ic"><use href="#i-plus"/></svg>Pengajuan</button></div></div>
    <div class="scroll"><table>
      <thead><tr><th>ID</th><th>Mitra</th><th>Diminta</th><th>Total</th><th>Pengajuan</th><th>Bayar</th></tr></thead>
      <tbody>
        @forelse ($pengajuan as $p)
          <tr><td class="mono">{{ $p->kode }}</td><td>{{ $p->mitra->nama_perusahaan }}</td><td class="mono">{{ number_format($p->jumlah_diminta,0,',','.') }}</td>
            <td class="mono">{{ $p->transaksi ? 'Rp '.number_format($p->transaksi->total_harga,0,',','.') : '-' }}</td>
            <td><x-badge :s="$p->status"/></td>
            <td>@if ($p->transaksi)<x-badge :s="$p->transaksi->status_bayar"/>@else<span class="sub">-</span>@endif</td></tr>
        @empty
          <tr><td colspan="6" class="sub empty">Belum ada pengajuan.</td></tr>
        @endforelse
      </tbody>
    </table></div>
  </section>

  <section class="card act">
    <div class="head"><h2>Aktivitas pemeliharaan</h2></div>
    <ul class="tl">
      @forelse ($aktivitas as $a)
        <li><span class="dot {{ $a->mortalitas >= 10 ? 'c' : ($a->mortalitas > 0 ? 'w' : '') }}"></span><div><b>{{ $a->jenis_aktivitas }}</b><small>{{ $a->tanggal->translatedFormat('j M') }}@if ($a->catatan) · {{ $a->catatan }}@endif @if ($a->mortalitas) · {{ $a->mortalitas }} ekor mati @endif</small></div></li>
      @empty
        <li><div class="sub">Belum ada aktivitas.</div></li>
      @endforelse
    </ul>
  </section>
</div>
@endsection
@push('modals')
  @include('modals.periode-baru')
  @include('modals.pengajuan-baru')
@endpush
