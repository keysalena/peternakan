<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokAyam extends Model
{
    protected $table = 'stok_ayam';
    protected $primaryKey = 'id_stok';
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['tgl_update' => 'datetime'];

    public function periode() { return $this->belongsTo(PeriodePemeliharaan::class, 'id_periode'); }
}
