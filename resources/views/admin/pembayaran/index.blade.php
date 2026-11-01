@extends('layouts.admin')
@section('title', 'Pembayaran')
@section('content')
<x-page-title title="Pembayaran" sub="Satu transaksi dapat dibayar lunas atau dicicil beberapa kali.">
  <button class="btn" data-open="pembayaran-baru"><svg class="ic"><use href="#i-plus"/></svg>Catat pembayaran</button>
</x-page-title>
<div class="grid">
  <x-stat icon="cash" label="Dana masuk" :value="'Rp '.number_format($masuk/1000000,1,',','.')" unit="juta" tone="ok" badge="tercatat"/>
  <x-stat icon="check" label="Lunas" :value="$count['lunas'] ?? 0" tone="ok" badge="lunas"/>
  <x-stat icon="card" label="Cicilan" :value="$count['cicilan'] ?? 0" tone="w" badge="berjalan"/>
  <x-stat icon="x" label="Gagal" :value="$count['gagal'] ?? 0" tone="c" badge="gagal"/>
  <section class="card full">
    <div class="head"><div class="tabs">
      @foreach (['' => 'Semua', 'lunas' => 'Lunas', 'cicilan' => 'Cicilan', 'gagal' => 'Gagal'] as $k => $l)
        <a class="chip {{ $status === $k ? 'on' : '' }}" href="{{ route('admin.pembayaran.index', array_filter(['status' => $k])) }}">{{ $l }}</a>
      @endforeach</div></div>
    <div class="scroll"><table style="min-width:720px">
      <thead><tr><th>ID</th><th>Transaksi</th><th>Mitra</th><th>Jumlah</th><th>Metode</th><th>Tanggal</th><th>Status</th></tr></thead>
      <tbody class="anim-rows">
        @foreach ($list as $b)
          <tr style="--n:{{ $loop->index }}"><td class="mono">{{ $b->kode }}</td><td class="mono">{{ $b->transaksi->kode }}</td><td><span class="pn">{{ $b->transaksi->pengajuan->mitra->nama_perusahaan }}</span></td>
            <td class="mono">Rp {{ number_format($b->jumlah_bayar,0,',','.') }}</td><td>{{ $b->metode }}</td><td class="mono">{{ $b->tgl_bayar->translatedFormat('j M Y') }}</td><td><x-badge :s="$b->status"/></td></tr>
        @endforeach
      </tbody>
    </table></div>
    @if ($list->isEmpty())<div class="sub empty">Belum ada pembayaran pada filter ini.</div>@endif
    {{ $list->links('partials.pagination') }}
  </section>
</div>
@endsection
@push('modals') @include('modals.pembayaran-baru', ['openTrx' => $openTrx]) @endpush
