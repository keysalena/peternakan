<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitra';
    protected $primaryKey = 'id_mitra';
    public $timestamps = false;
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function pengajuan() { return $this->hasMany(PengajuanPengambilan::class, 'id_mitra'); }

    public function getKodeAttribute(): string { return 'MTR-' . str_pad($this->id_mitra, 3, '0', STR_PAD_LEFT); }
    public function getInisialAttribute(): string
    {
        $kata = preg_split('/\s+/', trim($this->nama_perusahaan));
        return strtoupper(substr($kata[0], 0, 1) . substr($kata[1] ?? $kata[0], 0, 1));
    }
}
