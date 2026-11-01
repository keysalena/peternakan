/* Tema terang/gelap. Dimuat di <head> agar tidak berkedip saat halaman tampil. */
(function () {
  var root = document.documentElement, saved = null;
  try { saved = localStorage.getItem('tema'); } catch (e) {}
  root.dataset.theme = saved || (matchMedia('(prefers-color-scheme:dark)').matches ? 'dark' : 'light');
  document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('theme');
    if (!btn) return;
    btn.onclick = function () {
      var t = root.dataset.theme === 'dark' ? 'light' : 'dark';
      root.dataset.theme = t;
      try { localStorage.setItem('tema', t); } catch (e) {}
    };
  });
})();
