<div class="toast" id="toast" role="status" @if (session('ok')) data-flash="{{ session('ok') }}" @endif>
  <svg class="ic"><use href="#i-check"/></svg><span></span>
</div>
