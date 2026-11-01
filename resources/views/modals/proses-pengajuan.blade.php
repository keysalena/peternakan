<x-modal id="proses-pengajuan" title="Proses pengajuan" sub="" action="#" submit="Proses dan kurangi stok">
  <div class="f2">
    <label>Jumlah diambil<input type="number" name="jumlah_diambil" min="1" required value="{{ old('jumlah_diambil') }}"><span class="hint">dalam ekor, maksimal sesuai permintaan</span></label>
    <label>Harga per ekor<input type="number" name="harga_per_ekor" min="1" required value="{{ old('harga_per_ekor', 7000) }}"><span class="hint">dalam rupiah</span></label>
  </div>
  <label>Tanggal transaksi<input type="date" name="tgl_transaksi" required value="{{ old('tgl_transaksi', now()->toDateString()) }}"></label>
</x-modal>
