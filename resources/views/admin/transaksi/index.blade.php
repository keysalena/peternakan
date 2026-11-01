@extends('layouts.admin')
@section('title', 'Transaksi')
@section('content')
<x-page-title title="Transaksi" sub="Dibuat dari pengajuan yang disetujui.">
  <button class="btn" data-open="pembayaran-baru"><svg class="ic"><use href="#i-plus"/></svg>Catat pembayaran</button>
</x-page-title>
<div class="grid">
  <x-stat icon="card" label="Jumlah transaksi" :value="$jumlah"/>
  <x-stat icon="egg" label="Ayam keluar" :value="number_format($diambil,0,',','.')" unit="ekor"/>
  <x-stat icon="cash" label="Total tagihan" :value="'Rp '.number_format($tagihan/1000000,1,',','.')" unit="juta"/>
  <section class="card full">
    <div class="scroll"><table style="min-width:760px">
      <thead><tr><th>ID</th><th>Pengajuan</th><th>Mitra</th><th>Diambil</th><th>Total</th><th>Dibayar</th><th>Bayar</th></tr></thead>
      <tbody class="anim-rows">
        @foreach ($list as $t)
          <tr style="--n:{{ $loop->index }}"><td class="mono">{{ $t->kode }}</td><td class="mono">{{ $t->pengajuan->kode }}</td><td><span class="pn">{{ $t->pengajuan->mitra->nama_perusahaan }}</span><span class="sub">{{ $t->tgl_transaksi->translatedFormat('j M Y') }}</span></td>
            <td class="mono">{{ number_format($t->jumlah_diambil,0,',','.') }}</td><td class="mono">Rp {{ number_format($t->total_harga,0,',','.') }}</td>
            <td class="mono">Rp {{ number_format($t->total_dibayar,0,',','.') }}</td><td><x-badge :s="$t->status_bayar"/></td></tr>
        @endforeach
      </tbody>
    </table></div>
    @if ($list->isEmpty())<div class="sub empty">Belum ada transaksi. Proses pengajuan yang menunggu untuk membuatnya.</div>@endif
    {{ $list->links('partials.pagination') }}
  </section>
</div>
@endsection
@push('modals') @include('modals.pembayaran-baru', ['openTrx' => $openTrx]) @endpush
