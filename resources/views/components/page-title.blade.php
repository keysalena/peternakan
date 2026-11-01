@props(['title', 'sub' => null])
<div class="title">
  <div><h1>{{ $title }}</h1>@if ($sub)<div class="sub">{{ $sub }}</div>@endif</div>
  <div style="display:flex;gap:8px">{{ $slot }}</div>
</div>
