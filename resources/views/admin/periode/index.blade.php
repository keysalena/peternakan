@extends('layouts.admin')
@section('title', 'Periode pemeliharaan')
@section('content')
<x-page-title title="Periode pemeliharaan" sub="Satu periode memiliki satu catatan stok dan banyak aktivitas.">
  <button class="btn" data-open="periode-baru"><svg class="ic"><use href="#i-plus"/></svg>Periode baru</button>
</x-page-title>
<div class="grid"><section class="card full">
  <div class="scroll"><table style="min-width:900px">
    <thead><tr><th>Periode</th><th>Rentang</th><th>Awal</th><th>Stok</th><th>Mortalitas</th><th>Pengajuan</th><th>Estimasi</th><th>Status</th></tr></thead>
    <tbody class="anim-rows">
      @foreach ($list as $p)
        <tr style="--n:{{ $loop->index }}"><td><span class="pn">{{ $p->nama_periode }}</span></td><td class="sub">{{ $p->rentang }}</td>
          <td class="mono">{{ number_format($p->jumlah_awal_ayam,0,',','.') }}</td>
          <td class="mono">{{ number_format($p->stok->jumlah_tersedia ?? 0,0,',','.') }}</td>
          <td class="mono">{{ number_format($p->mati ?? 0,0,',','.') }}</td><td class="mono">{{ $p->pengajuan_count }}</td><td class="sub">{{ $p->estimasi }}</td>
          <td><form method="POST" action="{{ route('admin.periode.update', $p) }}">@csrf @method('PATCH')
            <select name="status" class="sel-sm" data-autosubmit aria-label="Status {{ $p->nama_periode }}">@foreach (['direncanakan','berjalan','selesai'] as $s)<option value="{{ $s }}" @selected($p->status===$s)>{{ ucfirst($s) }}</option>@endforeach</select></form></td></tr>
      @endforeach
    </tbody>
  </table></div>
  @if ($list->isEmpty())<div class="sub empty">Belum ada periode. Buat periode pertama dengan tombol di kanan atas.</div>@endif
  {{ $list->links('partials.pagination') }}
</section></div>
@endsection
@push('modals') @include('modals.periode-baru') @endpush
