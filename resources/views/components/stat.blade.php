{{-- tone: ok | w | c   bar: persen 0-100 (opsional) --}}
@props(['icon', 'label', 'value', 'unit' => null, 'tone' => null, 'badge' => null, 'bar' => null])
<section class="card stat">
  <div class="k"><span class="tile"><svg class="ic"><use href="#i-{{ $icon }}"/></svg></span>{{ $label }}@if ($badge)<span class="badge b-{{ $tone }}">{{ $badge }}</span>@endif</div>
  <div class="num">{{ $value }}@if ($unit)<small>{{ $unit }}</small>@endif</div>
  @if (!is_null($bar))<div class="bar"><i class="{{ $tone === 'w' || $tone === 'c' ? 'w' : '' }}" style="width:{{ max(0, min(100, $bar)) }}%"></i></div>@endif
</section>
