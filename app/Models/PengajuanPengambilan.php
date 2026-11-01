<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPengambilan extends Model
{
    protected $table = 'pengajuan_pengambilan';
    protected $primaryKey = 'id_pengajuan';
    protected $guarded = [];
    protected $casts = ['tgl_pengambilan' => 'date'];

    public function mitra() { return $this->belongsTo(Mitra::class, 'id_mitra'); }
    public function periode() { return $this->belongsTo(PeriodePemeliharaan::class, 'id_periode'); }
    public function transaksi() { return $this->hasOne(Transaksi::class, 'id_pengajuan'); }

    public function getKodeAttribute(): string { return 'PGJ-' . str_pad($this->id_pengajuan, 4, '0', STR_PAD_LEFT); }
}
