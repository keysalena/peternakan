@extends('layouts.admin')
@section('title', 'Informasi pembayaran')
@section('content')
<x-page-title title="Informasi pembayaran" sub="Ringkasan tagihan dan riwayat pembayaran Anda."/>
<div class="grid">
  <x-stat icon="card" label="Total tagihan" :value="'Rp '.number_format($tagihan/1000000,1,',','.')" unit="juta"/>
  <x-stat icon="cash" label="Sudah dibayar" :value="'Rp '.number_format($dibayar/1000000,1,',','.')" unit="juta" tone="ok" badge="tercatat" :bar="$tagihan ? round($dibayar/$tagihan*100) : 0"/>
  <x-stat icon="clip" label="Sisa tagihan" :value="'Rp '.number_format($sisa/1000000,1,',','.')" unit="juta" :tone="$sisa > 0 ? 'c' : 'ok'" :badge="$sisa > 0 ? 'belum lunas' : 'lunas'"/>

  @if ($belumLunas->isNotEmpty())
  <section class="card full">
    <div class="head"><h2>Transaksi belum lunas</h2></div>
    <div class="scroll"><table style="min-width:520px">
      <thead><tr><th>Transaksi</th><th>Total</th><th>Dibayar</th><th>Sisa</th></tr></thead>
      <tbody>@foreach ($belumLunas as $t)
        <tr><td class="mono">{{ $t->kode }}</td><td class="mono">Rp {{ number_format($t->total_harga,0,',','.') }}</td><td class="mono">Rp {{ number_format($t->total_dibayar,0,',','.') }}</td><td class="mono">Rp {{ number_format($t->sisa,0,',','.') }}</td></tr>
      @endforeach</tbody>
    </table></div>
    <p class="sub" style="margin-top:12px">Pembayaran dicatat oleh admin setelah dana diterima. Hubungi tim operasional bila ada selisih.</p>
  </section>
  @endif

  <section class="card full">
    <div class="head"><h2>Riwayat pembayaran</h2></div>
    <div class="scroll"><table style="min-width:600px">
      <thead><tr><th>ID</th><th>Transaksi</th><th>Jumlah</th><th>Metode</th><th>Tanggal</th><th>Status</th></tr></thead>
      <tbody class="anim-rows">
        @foreach ($list as $b)
          <tr style="--n:{{ $loop->index }}"><td class="mono">{{ $b->kode }}</td><td class="mono">{{ $b->transaksi->kode }}</td><td class="mono">Rp {{ number_format($b->jumlah_bayar,0,',','.') }}</td>
            <td>{{ $b->metode }}</td><td class="mono">{{ $b->tgl_bayar->translatedFormat('j M Y') }}</td><td><x-badge :s="$b->status"/></td></tr>
        @endforeach
      </tbody>
    </table></div>
    @if ($list->isEmpty())<div class="sub empty">Belum ada pembayaran tercatat.</div>@endif
    {{ $list->links('partials.pagination') }}
  </section>
</div>
@endsection
