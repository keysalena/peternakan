@props(['items' => []])
@if (count($items))
<section class="card" style="margin-bottom:16px" role="region" aria-label="Peringatan">
  <div class="head"><h2>Peringatan</h2><span class="badge b-{{ collect($items)->contains('level', 'c') ? 'c' : 'w' }}">{{ count($items) }} perlu perhatian</span></div>
  <ul class="tl">
    @foreach ($items as $i)
      <li><span class="dot {{ $i['level'] }}"></span><div><b>{{ $i['judul'] }}</b><small>{{ $i['pesan'] }}@if (!empty($i['url'])) · <a href="{{ $i['url'] }}">Lihat</a>@endif</small></div></li>
    @endforeach
  </ul>
</section>
@endif
