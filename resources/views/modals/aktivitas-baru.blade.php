<x-modal id="aktivitas-baru" title="Catat aktivitas" sub="Aktivitas pemeliharaan pada satu periode." :action="route('admin.aktivitas.store')" submit="Simpan aktivitas">
  <label>Periode<select name="id_periode" required>@foreach ($periodeSelect as $p)<option value="{{ $p->id_periode }}" @selected(old('id_periode', $idPeriode ?? null)==$p->id_periode)>{{ $p->nama_periode }}</option>@endforeach</select></label>
  <div class="f2">
    <label>Tanggal<input type="date" name="tanggal" required value="{{ old('tanggal', now()->toDateString()) }}"></label>
    <label>Jenis aktivitas<select name="jenis_aktivitas">@foreach ($jenis as $j)<option @selected(old('jenis_aktivitas')===$j)>{{ $j }}</option>@endforeach</select></label>
  </div>
  <label>Mortalitas<input type="number" name="mortalitas" min="0" value="{{ old('mortalitas', 0) }}"><span class="hint">jumlah ayam mati, dalam ekor</span></label>
  <label>Catatan<textarea name="catatan" maxlength="500" placeholder="Kandang, dosis, atau temuan lain">{{ old('catatan') }}</textarea></label>
</x-modal>
