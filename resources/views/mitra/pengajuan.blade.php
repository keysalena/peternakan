@extends('layouts.admin')
@section('title', 'Pengajuan pengambilan')
@section('content')
<x-page-title title="Pengajuan pengambilan" sub="Ajukan ayam dan pantau statusnya.">
  @if ($mitra->status_verifikasi === 'terverifikasi' && $periode)
    <button class="btn" data-open="mitra-pengajuan"><svg class="ic"><use href="#i-plus"/></svg>Ajukan pengambilan</button>
  @endif
</x-page-title>

@if ($mitra->status_verifikasi !== 'terverifikasi')
  <section class="card" style="margin-bottom:16px"><b>Akun belum terverifikasi</b><div class="sub">Pengajuan dapat dikirim setelah admin memverifikasi akun Anda.</div></section>
@elseif (! $periode)
  <section class="card" style="margin-bottom:16px"><b>Belum ada periode yang berjalan</b><div class="sub">Pengajuan dibuka saat periode pemeliharaan berikutnya dimulai.</div></section>
@endif

<div class="grid"><section class="card full">
  <div class="scroll"><table style="min-width:640px">
    <thead><tr><th>ID</th><th>Periode</th><th>Diminta</th><th>Tgl ambil</th><th>Status</th><th>Transaksi</th></tr></thead>
    <tbody class="anim-rows">
      @foreach ($list as $p)
        <tr style="--n:{{ $loop->index }}"><td class="mono">{{ $p->kode }}</td><td>{{ $p->periode->nama_periode }}</td><td class="mono">{{ number_format($p->jumlah_diminta,0,',','.') }}</td>
          <td class="mono">{{ $p->tgl_pengambilan->translatedFormat('j M Y') }}</td><td><x-badge :s="$p->status"/></td>
          <td class="sub">{{ $p->transaksi?->kode ?? '-' }}</td></tr>
      @endforeach
    </tbody>
  </table></div>
  @if ($list->isEmpty())<div class="sub empty">Belum ada pengajuan.</div>@endif
  {{ $list->links('partials.pagination') }}
</section></div>
@endsection
@push('modals') @include('modals.mitra-pengajuan-baru', ['stok' => $stok]) @endpush
