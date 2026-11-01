@props(['s'])
@php
  $tone = match ($s) {
    'terverifikasi', 'disetujui', 'lunas', 'berjalan', 'selesai' => 'ok',
    'ditolak', 'gagal' => 'c',
    default => 'w',   // menunggu, cicilan, belum bayar, direncanakan
  };
@endphp
<span class="badge b-{{ $tone }}">{{ $s }}</span>
