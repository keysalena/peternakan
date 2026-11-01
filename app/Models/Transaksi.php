<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['tgl_transaksi' => 'date'];

    public function pengajuan() { return $this->belongsTo(PengajuanPengambilan::class, 'id_pengajuan'); }
    public function pembayaran() { return $this->hasMany(Pembayaran::class, 'id_transaksi'); }

    public function getKodeAttribute(): string { return 'TRX-' . str_pad($this->id_transaksi, 4, '0', STR_PAD_LEFT); }

    /** Total yang sudah masuk (pembayaran gagal tidak dihitung). */
    public function getTotalDibayarAttribute(): int
    {
        return (int) $this->pembayaran->where('status', '!=', 'gagal')->sum('jumlah_bayar');
    }
    public function getSisaAttribute(): int { return max($this->total_harga - $this->total_dibayar, 0); }
    public function getStatusBayarAttribute(): string
    {
        if ($this->total_dibayar >= $this->total_harga) return 'lunas';
        return $this->total_dibayar > 0 ? 'cicilan' : 'belum bayar';
    }
}
