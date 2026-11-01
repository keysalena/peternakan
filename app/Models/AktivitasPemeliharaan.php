<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasPemeliharaan extends Model
{
    protected $table = 'aktivitas_pemeliharaan';
    protected $primaryKey = 'id_aktivitas';
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['tanggal' => 'date'];

    public function periode() { return $this->belongsTo(PeriodePemeliharaan::class, 'id_periode'); }
}
