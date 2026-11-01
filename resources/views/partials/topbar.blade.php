<header>
  <div class="user">
    <span class="sub">{{ auth()->user()->username }}</span>
    <button class="iconbtn" id="theme" type="button" aria-label="Ganti tema"><svg class="ic moon"><use href="#i-moon"/></svg><svg class="ic sun"><use href="#i-sun"/></svg></button>
    <button class="iconbtn" type="button" aria-label="Notifikasi"><svg class="ic"><use href="#i-bell"/></svg></button>
    <div class="av">{{ strtoupper(substr(auth()->user()->username, 0, 2)) }}</div>
  </div>
</header>
