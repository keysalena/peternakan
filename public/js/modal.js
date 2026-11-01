/* Dialog modal.
   Tombol pembuka : <button data-open="id-dialog" [data-action="/url"] [data-fill='{"nama":"nilai"}'] [data-label="teks"]>
   Penutup        : elemen apa pun dengan atribut data-close, atau klik di luar dialog. */
(function () {
  function closeDlg(d) {
    d.classList.add('closing');
    setTimeout(function () { d.close(); d.classList.remove('closing'); }, 180);
  }
  function openDlg(d, btn) {
    var f = d.querySelector('form');
    if (btn) {
      if (btn.dataset.action) {
        f.action = btn.dataset.action;
        var a = f.querySelector('[name=_action]');
        if (a) a.value = btn.dataset.action;
      }
      if (btn.dataset.fill) {
        var vals = JSON.parse(btn.dataset.fill);
        Object.keys(vals).forEach(function (k) {
          var inp = f.elements[k];
          if (inp) inp.value = vals[k];
        });
      }
      var lab = d.querySelector('[data-label]');
      if (lab && btn.dataset.label) lab.textContent = btn.dataset.label;
    }
    d.showModal();
    var first = f.querySelector('input:not([type=hidden]),select,textarea');
    if (first) first.focus();
  }
  document.querySelectorAll('[data-open]').forEach(function (b) {
    b.addEventListener('click', function () {
      var d = document.getElementById(b.dataset.open);
      if (d) openDlg(d, b);
    });
  });
  document.querySelectorAll('dialog').forEach(function (d) {
    d.addEventListener('click', function (e) {
      if (e.target === d || e.target.closest('[data-close]')) closeDlg(d);
    });
    /* buka lagi otomatis bila validasi server gagal */
    if (d.hasAttribute('data-reopen')) d.showModal();
  });
})();
