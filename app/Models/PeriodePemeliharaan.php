<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodePemeliharaan extends Model
{
    protected $table = 'periode_pemeliharaan';
    protected $primaryKey = 'id_periode';
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['tgl_mulai' => 'date', 'tgl_selesai' => 'date'];

    public function aktivitas() { return $this->hasMany(AktivitasPemeliharaan::class, 'id_periode'); }
    public function stok() { return $this->hasOne(StokAyam::class, 'id_periode'); }
    public function pengajuan() { return $this->hasMany(PengajuanPengambilan::class, 'id_periode'); }

    public function scopeBerjalan($q) { return $q->where('status', 'berjalan'); }
    public function getRentangAttribute(): string
    {
        return $this->tgl_mulai->translatedFormat('j M') . ' – ' . $this->tgl_selesai->translatedFormat('j M Y');
    }
}
