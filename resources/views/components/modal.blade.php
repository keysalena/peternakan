{{-- Dialog berisi form POST. $method boleh PATCH/PUT/DELETE. Slot = isi kolom form. --}}
@props(['id', 'title', 'sub' => '', 'action' => '#', 'method' => 'POST', 'submit' => 'Simpan'])
@php $reopen = old('_modal') === $id && $errors->any(); @endphp
<dialog id="{{ $id }}" aria-labelledby="{{ $id }}-t" @if ($reopen) data-reopen @endif>
  <form method="POST" action="{{ $reopen && old('_action') ? old('_action') : $action }}">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <input type="hidden" name="_modal" value="{{ $id }}">
    <input type="hidden" name="_action" value="{{ old('_action') }}">
    <div class="mh">
      <div><h2 id="{{ $id }}-t">{{ $title }}</h2><div class="sub" data-label>{{ $sub }}</div></div>
      <button type="button" class="iconbtn" data-close aria-label="Tutup"><svg class="ic"><use href="#i-x"/></svg></button>
    </div>
    {{ $slot }}
    <div class="err" role="alert">@if ($reopen){{ $errors->first() }}@endif</div>
    <div class="mf"><button type="button" class="btn ghost" data-close>Batal</button><button class="btn" type="submit">{{ $submit }}</button></div>
  </form>
</dialog>
