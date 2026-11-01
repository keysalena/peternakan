<x-modal id="periode-baru" title="Periode baru" sub="Mulai siklus pemeliharaan baru." :action="route('admin.periode.store')" submit="Simpan periode">
  <label>Nama periode<input name="nama_periode" required placeholder="Periode 13" value="{{ old('nama_periode') }}"></label>
  <div class="f2">
    <label>Tanggal mulai<input type="date" name="tgl_mulai" required value="{{ old('tgl_mulai') }}"></label>
    <label>Tanggal selesai<input type="date" name="tgl_selesai" required value="{{ old('tgl_selesai') }}"></label>
  </div>
  <div class="f2">
    <label>Jumlah awal ayam<input type="number" name="jumlah_awal_ayam" min="1" required placeholder="10000" value="{{ old('jumlah_awal_ayam') }}"><span class="hint">dalam ekor</span></label>
    <label>Status<select name="status">@foreach (['direncanakan','berjalan','selesai'] as $s)<option value="{{ $s }}" @selected(old('status','direncanakan')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></label>
  </div>
</x-modal>
