@extends('layouts.admin')
@section('title', 'Stok ayam')
@section('content')
<x-page-title title="Stok ayam" sub="Stok berkurang otomatis setiap pengajuan diproses menjadi transaksi."/>
<div class="grid"><section class="card full">
  <div class="scroll"><table style="min-width:640px">
    <thead><tr><th>Periode</th><th>Jumlah awal</th><th>Tersedia</th><th>Sudah keluar</th><th>Diperbarui</th><th>Aksi</th></tr></thead>
    <tbody class="anim-rows">
      @foreach ($list as $s)
        @php $persen = $s->periode->jumlah_awal_ayam ? round($s->jumlah_tersedia / $s->periode->jumlah_awal_ayam * 100) : 0; @endphp
        <tr style="--n:{{ $loop->index }}"><td><span class="pn">{{ $s->periode->nama_periode }}</span><x-badge :s="$s->periode->status"/></td>
          <td class="mono">{{ number_format($s->periode->jumlah_awal_ayam,0,',','.') }}</td>
          <td><span class="mono">{{ number_format($s->jumlah_tersedia,0,',','.') }}</span><div class="bar"><i style="width:{{ $persen }}%"></i></div></td>
          <td class="mono">{{ number_format($s->periode->jumlah_awal_ayam - $s->jumlah_tersedia,0,',','.') }}</td>
          <td class="sub">{{ $s->tgl_update->translatedFormat('j M Y, H:i') }}</td>
          <td><button class="btn ghost sm" data-open="stok-sesuaikan" data-action="{{ route('admin.stok.update', $s) }}" data-fill='{"jumlah_tersedia":{{ $s->jumlah_tersedia }}}' data-label="{{ $s->periode->nama_periode }} · maksimal {{ number_format($s->periode->jumlah_awal_ayam,0,',','.') }} ekor">Sesuaikan</button></td></tr>
      @endforeach
    </tbody>
  </table></div>
  @if ($list->isEmpty())<div class="sub empty">Stok dibuat otomatis saat periode baru disimpan.</div>@endif
</section></div>
@endsection
@push('modals') @include('modals.stok-sesuaikan') @endpush
