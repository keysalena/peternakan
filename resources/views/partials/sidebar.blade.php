@php
  $nav = [
    ['admin.dashboard',        'dash',  'Dashboard',  'admin.dashboard'],
    ['admin.mitra.index',      'users', 'Mitra',      'admin.mitra.*'],
    ['admin.periode.index',    'cal',   'Periode',    'admin.periode.*'],
    ['admin.aktivitas.index',  'act',   'Aktivitas',  'admin.aktivitas.*'],
    ['admin.pengajuan.index',  'clip',  'Pengajuan',  'admin.pengajuan.*'],
    ['admin.transaksi.index',  'card',  'Transaksi',  'admin.transaksi.*'],
    ['admin.pembayaran.index', 'cash',  'Pembayaran', 'admin.pembayaran.*'],
    ['admin.stok.index',       'box',   'Stok ayam',  'admin.stok.*'],
  ];
@endphp
<aside>
  <span class="ind" id="ind"></span>
  <div class="logo"><i><svg class="ic"><use href="#i-egg"/></svg></i>TernakKu</div>
  @foreach ($nav as [$route, $icon, $label, $pattern])
    <a href="{{ route($route) }}" class="{{ request()->routeIs($pattern) ? 'on' : '' }}"><svg class="ic"><use href="#i-{{ $icon }}"/></svg>{{ $label }}</a>
  @endforeach
  <div class="sep"></div>
  <a href="#"><svg class="ic"><use href="#i-set"/></svg>Pengaturan</a>
  <a href="#" data-logout><svg class="ic"><use href="#i-out"/></svg>Keluar</a>
  <div class="help"><b><svg class="ic"><use href="#i-help"/></svg>Ada kendala?</b>Hubungi tim operasional kapan saja.<br><button type="button">Hubungi</button></div>
</aside>
