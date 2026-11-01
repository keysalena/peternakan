@extends('layouts.admin')
@section('title', 'Aktivitas pemeliharaan')
@section('content')
<x-page-title title="Aktivitas pemeliharaan" sub="Catatan harian vaksinasi, pakan, penimbangan, dan mortalitas.">
  <button class="btn" data-open="aktivitas-baru"><svg class="ic"><use href="#i-plus"/></svg>Catat aktivitas</button>
</x-page-title>
<div class="grid">
  <x-stat icon="act" label="Aktivitas tercatat" :value="$list->total()"/>
  <x-stat icon="down" label="Total mortalitas" :value="number_format($mati,0,',','.')" unit="ekor" tone="c" badge="periode ini"/>
  <section class="card full">
    <div class="head" style="flex-wrap:wrap"><h2>Riwayat</h2>
      <form method="GET" action="{{ route('admin.aktivitas.index') }}"><select name="periode" class="sel-sm" data-autosubmit aria-label="Pilih periode">@foreach ($periodeSelect as $p)<option value="{{ $p->id_periode }}" @selected($idPeriode==$p->id_periode)>{{ $p->nama_periode }}</option>@endforeach</select></form></div>
    <div class="scroll"><table style="min-width:640px">
      <thead><tr><th>Tanggal</th><th>Jenis</th><th>Mortalitas</th><th>Catatan</th></tr></thead>
      <tbody class="anim-rows">
        @foreach ($list as $a)
          <tr style="--n:{{ $loop->index }}"><td class="mono">{{ $a->tanggal->translatedFormat('j M Y') }}</td><td><span class="pn">{{ $a->jenis_aktivitas }}</span></td><td class="mono">{{ $a->mortalitas }}</td><td class="sub">{{ $a->catatan ?: '-' }}</td></tr>
        @endforeach
      </tbody>
    </table></div>
    @if ($list->isEmpty())<div class="sub empty">Belum ada aktivitas pada periode ini.</div>@endif
    {{ $list->links('partials.pagination') }}
  </section>
</div>
@endsection
@push('modals') @include('modals.aktivitas-baru', ['periodeSelect' => $periodeSelect, 'idPeriode' => $idPeriode, 'jenis' => $jenis]) @endpush
