/* Perilaku kecil lain */
(function () {
  /* Keluar: kirim form POST tersembunyi */
  document.querySelectorAll('[data-logout]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      e.preventDefault();
      document.getElementById('logout-form').submit();
    });
  });
  /* <select data-autosubmit> langsung mengirim form saat diubah */
  document.querySelectorAll('[data-autosubmit]').forEach(function (s) {
    s.addEventListener('change', function () { s.form.requestSubmit(); });
  });
  /* <form data-confirm="pesan"> meminta konfirmasi sebelum dikirim */
  document.querySelectorAll('form[data-confirm]').forEach(function (f) {
    f.addEventListener('submit', function (e) {
      if (!confirm(f.dataset.confirm)) e.preventDefault();
    });
  });
})();
