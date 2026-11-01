<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $t) {
            $t->id('id_transaksi');
            $t->foreignId('id_pengajuan')->unique()->constrained('pengajuan_pengambilan', 'id_pengajuan'); // pengajuan 1:1 transaksi
            $t->unsignedInteger('jumlah_diambil');
            $t->unsignedBigInteger('total_harga');
            $t->date('tgl_transaksi');
        });
    }
    public function down(): void { Schema::dropIfExists('transaksi'); }
};
