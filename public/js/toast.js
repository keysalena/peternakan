/* Toast. Dipanggil otomatis bila ada flash 'ok' dari server; juga bisa lewat window.toast('pesan') */
(function () {
  var el = document.getElementById('toast');
  if (!el) return;
  window.toast = function (msg) {
    el.querySelector('span').textContent = msg;
    el.classList.add('show');
    setTimeout(function () { el.classList.remove('show'); }, 2600);
  };
  if (el.dataset.flash) window.toast(el.dataset.flash);
})();
