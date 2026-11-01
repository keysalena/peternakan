<x-modal id="mitra-baru" title="Mitra baru" sub="Akun baru berstatus menunggu verifikasi." :action="route('admin.mitra.store')" submit="Simpan mitra">
  <label>Nama perusahaan<input name="nama_perusahaan" required placeholder="PT Contoh Makmur" value="{{ old('nama_perusahaan') }}"></label>
  <div class="f2">
    <label>Bentuk usaha<select name="bentuk_usaha"><option>PT</option><option @selected(old('bentuk_usaha')==='CV')>CV</option></select></label>
    <label>Kontak<input name="kontak" required placeholder="0812-0000-0000" value="{{ old('kontak') }}"></label>
  </div>
  <label>Alamat<input name="alamat" required placeholder="Kota, kecamatan" value="{{ old('alamat') }}"></label>
  <div class="f2">
    <label>Username<input name="username" required autocomplete="off" value="{{ old('username') }}"></label>
    <label>Password<input type="password" name="password" minlength="6" required autocomplete="new-password"><span class="hint">minimal 6 karakter</span></label>
  </div>
</x-modal>
