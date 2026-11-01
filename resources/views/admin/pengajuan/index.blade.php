@extends('layouts.admin')
@section('title', 'Pengajuan pengambilan')
@section('content')
<x-page-title title="Pengajuan pengambilan" sub="Proses pengajuan untuk membuat transaksi dan mengurangi stok.">
  <button class="btn" data-open="pengajuan-baru"><svg class="ic"><use href="#i-plus"/></svg>Pengajuan</button>
</x-page-title>
<div class="grid">
  <x-stat icon="clip" label="Total pengajuan" :value="$total"/>
  <x-stat icon="clip" label="Menunggu" :value="$count['menunggu'] ?? 0" tone="w" badge="perlu cek"/>
  <x-stat icon="check" label="Disetujui" :value="$count['disetujui'] ?? 0" tone="ok" badge="diproses"/>
  <x-stat icon="x" label="Ditolak" :value="$count['ditolak'] ?? 0" tone="c" badge="ditolak"/>
  <section class="card full">
    <div class="head"><div class="tabs">
      @foreach (['' => 'Semua', 'menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'] as $k => $l)
        <a class="chip {{ $status === $k ? 'on' : '' }}" href="{{ route('admin.pengajuan.index', array_filter(['status' => $k])) }}">{{ $l }}</a>
      @endforeach</div></div>
    <div class="scroll"><table style="min-width:760px">
      <thead><tr><th>ID</th><th>Mitra</th><th>Periode</th><th>Diminta</th><th>Tgl ambil</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody class="anim-rows">
        @foreach ($list as $p)
          <tr style="--n:{{ $loop->index }}"><td class="mono">{{ $p->kode }}</td><td><span class="pn">{{ $p->mitra->nama_perusahaan }}</span></td><td>{{ $p->periode->nama_periode }}</td>
            <td class="mono">{{ number_format($p->jumlah_diminta,0,',','.') }}</td><td class="mono">{{ $p->tgl_pengambilan->translatedFormat('j M Y') }}</td>
            <td><x-badge :s="$p->status"/></td>
            <td>@if ($p->status === 'menunggu')
              <div class="acts">
                <button class="btn sm" data-open="proses-pengajuan" data-action="{{ route('admin.pengajuan.proses', $p) }}" data-fill='{"jumlah_diambil":{{ $p->jumlah_diminta }}}' data-label="{{ $p->kode }} · {{ $p->mitra->nama_perusahaan }} · diminta {{ number_format($p->jumlah_diminta,0,',','.') }} ekor">Proses</button>
                <form method="POST" action="{{ route('admin.pengajuan.tolak', $p) }}" data-confirm="Tolak {{ $p->kode }}?">@csrf @method('PATCH')<button class="btn ghost sm">Tolak</button></form>
              </div>@elseif ($p->transaksi)<span class="sub">{{ $p->transaksi->kode }}</span>@else<span class="sub">-</span>@endif</td></tr>
        @endforeach
      </tbody>
    </table></div>
    @if ($list->isEmpty())<div class="sub empty">Belum ada pengajuan pada filter ini.</div>@endif
    {{ $list->links('partials.pagination') }}
  </section>
</div>
@endsection
@push('modals') @include('modals.pengajuan-baru') @include('modals.proses-pengajuan') @endpush
