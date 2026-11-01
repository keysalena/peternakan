/* Indikator aktif pada sidebar */
(function () {
  var ind = document.getElementById('ind');
  if (!ind) return;
  function place() {
    var a = document.querySelector('aside a.on');
    if (!a) return;
    ind.style.transform = 'translateY(' + a.offsetTop + 'px)';
    ind.style.height = a.offsetHeight + 'px';
  }
  place();
  requestAnimationFrame(function () { requestAnimationFrame(function () { ind.classList.add('ready'); }); });
  addEventListener('resize', place);
  addEventListener('load', place);
})();
