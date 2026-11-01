<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['tgl_bayar' => 'date'];

    public function transaksi() { return $this->belongsTo(Transaksi::class, 'id_transaksi'); }

    public function getKodeAttribute(): string { return 'BYR-' . str_pad($this->id_pembayaran, 4, '0', STR_PAD_LEFT); }
}
