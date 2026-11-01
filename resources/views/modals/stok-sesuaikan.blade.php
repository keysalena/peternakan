<x-modal id="stok-sesuaikan" title="Sesuaikan stok" sub="" action="#" method="PATCH" submit="Simpan stok">
  <label>Jumlah tersedia<input type="number" name="jumlah_tersedia" min="0" required value="{{ old('jumlah_tersedia') }}"><span class="hint">dalam ekor, hasil hitung ulang di kandang</span></label>
</x-modal>
