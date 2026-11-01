<x-modal id="mitra-pengajuan" title="Ajukan pengambilan" :sub="'Stok tersedia saat ini: '.number_format($stok,0,',','.').' ekor'" :action="route('mitra.pengajuan.store')" submit="Kirim pengajuan">
  <div class="f2">
    <label>Jumlah diminta<input type="number" name="jumlah_diminta" min="1" max="{{ $stok }}" required placeholder="1000" value="{{ old('jumlah_diminta') }}"><span class="hint">dalam ekor</span></label>
    <label>Tanggal pengambilan<input type="date" name="tgl_pengambilan" required min="{{ now()->toDateString() }}" value="{{ old('tgl_pengambilan') }}"></label>
  </div>
</x-modal>
