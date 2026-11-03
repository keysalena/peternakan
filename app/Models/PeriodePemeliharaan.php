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

    // --- estimasi siap panen (dihitung dari tgl_mulai dan tgl_selesai periode) ---
    public function getUmurHariAttribute(): int
    {
        return max((int) $this->tgl_mulai->copy()->startOfDay()->diffInDays(now()->startOfDay(), false), 0);
    }
    public function getTotalHariAttribute(): int
    {
        return max((int) $this->tgl_mulai->copy()->startOfDay()->diffInDays($this->tgl_selesai->copy()->startOfDay(), false), 1);
    }
    public function getSisaHariAttribute(): int
    {
        return max((int) now()->startOfDay()->diffInDays($this->tgl_selesai->copy()->startOfDay(), false), 0);
    }
    public function getProgresAttribute(): int
    {
        return (int) min(100, round($this->umur_hari / $this->total_hari * 100));
    }
    public function getEstimasiAttribute(): string
    {
        if ($this->status === 'selesai') return 'Periode selesai';
        if (now()->startOfDay()->lt($this->tgl_mulai->copy()->startOfDay())) return 'Dimulai ' . $this->tgl_mulai->translatedFormat('j M Y');
        if ($this->sisa_hari === 0) return 'Siap diambil sekarang';
        return "Siap diambil sekitar {$this->sisa_hari} hari lagi ({$this->tgl_selesai->translatedFormat('j M')})";
    }
}
