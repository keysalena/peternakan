@php
  $mobile = auth()->user()->isMitra() ? [
    ['mitra.dashboard',        'dash', 'Dashboard',  'mitra.dashboard'],
    ['mitra.pengajuan.index',  'clip', 'Pengajuan',  'mitra.pengajuan.*'],
    ['mitra.transaksi.index',  'card', 'Transaksi',  'mitra.transaksi.*'],
    ['mitra.pembayaran.index', 'cash', 'Pembayaran', 'mitra.pembayaran.*'],
  ] : [
    ['admin.dashboard',       'dash', 'Dashboard', 'admin.dashboard'],
    ['admin.mitra.index',     'users','Mitra',     'admin.mitra.*'],
    ['admin.pengajuan.index', 'clip', 'Pengajuan', 'admin.pengajuan.*'],
    ['admin.transaksi.index', 'card', 'Transaksi', 'admin.transaksi.*'],
    ['admin.stok.index',      'box',  'Stok',      'admin.stok.*'],
  ];
@endphp
<nav class="menu">
  @foreach ($mobile as [$route, $icon, $label, $pattern])
    <a href="{{ route($route) }}" class="{{ request()->routeIs($pattern) ? 'on' : '' }}"><svg class="ic"><use href="#i-{{ $icon }}"/></svg>{{ $label }}</a>
  @endforeach
</nav>
