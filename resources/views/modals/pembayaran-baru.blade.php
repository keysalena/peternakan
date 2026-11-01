<x-modal id="pembayaran-baru" title="Catat pembayaran" sub="Pembayaran untuk satu transaksi." :action="route('admin.pembayaran.store')" submit="Simpan pembayaran">
  <label>Transaksi<select name="id_transaksi" required><option value="">Pilih transaksi</option>@foreach ($openTrx as $t)<option value="{{ $t->id_transaksi }}" @selected(old('id_transaksi')==$t->id_transaksi)>{{ $t->kode }} · {{ $t->pengajuan->mitra->nama_perusahaan }} · sisa Rp {{ number_format($t->sisa,0,',','.') }}</option>@endforeach</select></label>
  <div class="f2">
    <label>Jumlah bayar<input type="number" name="jumlah_bayar" min="1" required value="{{ old('jumlah_bayar') }}"><span class="hint">dalam rupiah</span></label>
    <label>Tanggal bayar<input type="date" name="tgl_bayar" required value="{{ old('tgl_bayar', now()->toDateString()) }}"></label>
  </div>
  <div class="f2">
    <label>Metode<select name="metode">@foreach (\App\Http\Controllers\Admin\PembayaranController::METODE as $m)<option @selected(old('metode')===$m)>{{ $m }}</option>@endforeach</select></label>
    <label>Status<select name="status">@foreach (['lunas','cicilan','gagal'] as $s)<option value="{{ $s }}" @selected(old('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></label>
  </div>
</x-modal>
