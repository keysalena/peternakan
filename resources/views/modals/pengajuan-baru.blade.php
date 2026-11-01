<x-modal id="pengajuan-baru" title="Pengajuan pengambilan" sub="Catat permintaan ayam dari mitra." :action="route('admin.pengajuan.store')" submit="Kirim pengajuan">
  <label>Mitra<select name="id_mitra" required><option value="">Pilih mitra</option>@foreach ($mitraSelect as $m)<option value="{{ $m->id_mitra }}" @selected(old('id_mitra')==$m->id_mitra)>{{ $m->nama_perusahaan }}</option>@endforeach</select></label>
  <label>Periode<select name="id_periode" required>@foreach ($periodeSelect as $p)<option value="{{ $p->id_periode }}">{{ $p->nama_periode }} (aktif)</option>@endforeach</select></label>
  <div class="f2">
    <label>Jumlah diminta<input type="number" name="jumlah_diminta" min="1" required placeholder="1000" value="{{ old('jumlah_diminta') }}"><span class="hint">dalam ekor</span></label>
    <label>Tanggal pengambilan<input type="date" name="tgl_pengambilan" required value="{{ old('tgl_pengambilan') }}"></label>
  </div>
</x-modal>
