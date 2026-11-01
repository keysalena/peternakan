@extends('layouts.admin')
@section('title', 'Data mitra')
@section('content')
<x-page-title title="Data mitra" sub="Kelola perusahaan mitra dan verifikasi akunnya.">
  <button class="btn" data-open="mitra-baru"><svg class="ic"><use href="#i-plus"/></svg>Mitra baru</button>
</x-page-title>
<div class="grid">
  <x-stat icon="users" label="Total mitra" :value="$total"/>
  <x-stat icon="check" label="Terverifikasi" :value="$count['terverifikasi'] ?? 0" tone="ok" badge="aktif"/>
  <x-stat icon="clip" label="Menunggu" :value="$count['menunggu'] ?? 0" tone="w" badge="perlu cek"/>
  <x-stat icon="x" label="Ditolak" :value="$count['ditolak'] ?? 0" tone="c" badge="ditolak"/>

  <section class="card full">
    <div class="head" style="flex-wrap:wrap">
      <div class="tabs">
        @foreach (['' => 'Semua', 'terverifikasi' => 'Terverifikasi', 'menunggu' => 'Menunggu', 'ditolak' => 'Ditolak'] as $k => $l)
          <a class="chip {{ $status === $k ? 'on' : '' }}" href="{{ route('admin.mitra.index', array_filter(['status' => $k, 'q' => $q])) }}">{{ $l }}</a>
        @endforeach
      </div>
      <form class="search" method="GET" action="{{ route('admin.mitra.index') }}">
        <svg class="ic"><use href="#i-search"/></svg>
        @if ($status)<input type="hidden" name="status" value="{{ $status }}">@endif
        <input name="q" type="search" value="{{ $q }}" placeholder="Cari nama atau kota" aria-label="Cari mitra">
      </form>
    </div>
    <div class="scroll"><table style="min-width:720px">
      <thead><tr><th>ID</th><th>Perusahaan</th><th>Bentuk</th><th>Kontak</th><th>Pengajuan</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody class="anim-rows">
        @foreach ($list as $m)
          <tr style="--n:{{ $loop->index }}"><td class="mono">{{ $m->kode }}</td>
            <td><span class="pn">{{ $m->nama_perusahaan }}</span><span class="sub">{{ $m->alamat }}</span></td>
            <td>{{ $m->bentuk_usaha }}</td><td class="mono">{{ $m->kontak }}</td><td class="mono">{{ $m->pengajuan_count }}</td>
            <td><x-badge :s="$m->status_verifikasi"/></td>
            <td>@if ($m->status_verifikasi === 'menunggu')
              <div class="acts">
                <form method="POST" action="{{ route('admin.mitra.verifikasi', $m) }}">@csrf @method('PATCH')<input type="hidden" name="status_verifikasi" value="terverifikasi"><button class="btn sm">Verifikasi</button></form>
                <form method="POST" action="{{ route('admin.mitra.verifikasi', $m) }}" data-confirm="Tolak {{ $m->nama_perusahaan }}?">@csrf @method('PATCH')<input type="hidden" name="status_verifikasi" value="ditolak"><button class="btn ghost sm">Tolak</button></form>
              </div>@else<span class="sub">-</span>@endif</td></tr>
        @endforeach
      </tbody>
    </table></div>
    @if ($list->isEmpty())<div class="sub empty">Tidak ada mitra yang cocok. Ubah filter atau kata kunci.</div>@endif
    {{ $list->links('partials.pagination') }}
  </section>
</div>
@endsection
@push('modals') @include('modals.mitra-baru') @endpush
