@extends('layouts.admin')
@section('title', 'Riwayat transaksi')
@section('content')
<x-page-title title="Riwayat transaksi" sub="Transaksi dari pengajuan yang sudah disetujui."/>
<div class="grid"><section class="card full">
  <div class="scroll"><table style="min-width:880px">
    <thead><tr><th>ID</th><th>Pengajuan</th><th>Tanggal</th><th>Diambil</th><th>Total</th><th>Dibayar</th><th>Sisa</th><th>Status</th><th>Ambil</th><th>Nota</th></tr></thead>
    <tbody class="anim-rows">
      @foreach ($list as $t)
        <tr style="--n:{{ $loop->index }}"><td class="mono">{{ $t->kode }}</td><td class="mono">{{ $t->pengajuan->kode }}</td><td class="mono">{{ $t->tgl_transaksi->translatedFormat('j M Y') }}</td>
          <td class="mono">{{ number_format($t->jumlah_diambil,0,',','.') }}</td><td class="mono">Rp {{ number_format($t->total_harga,0,',','.') }}</td>
          <td class="mono">Rp {{ number_format($t->total_dibayar,0,',','.') }}</td><td class="mono">Rp {{ number_format($t->sisa,0,',','.') }}</td>
          <td><x-badge :s="$t->status_bayar"/></td>
          <td><x-badge :s="$t->status_ambil"/></td><td><a class="btn ghost sm" href="{{ route('nota', $t) }}" target="_blank" rel="noopener">Lihat nota</a></td></tr>
      @endforeach
    </tbody>
  </table></div>
  @if ($list->isEmpty())<div class="sub empty">Belum ada transaksi.</div>@endif
  {{ $list->links('partials.pagination') }}
</section></div>
@endsection
