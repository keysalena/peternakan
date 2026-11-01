<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $t) {
            $t->id('id_pembayaran');
            $t->foreignId('id_transaksi')->constrained('transaksi', 'id_transaksi')->cascadeOnDelete(); // transaksi 1:N pembayaran
            $t->unsignedBigInteger('jumlah_bayar');
            $t->string('metode');
            $t->enum('status', ['lunas', 'cicilan', 'gagal']);
            $t->date('tgl_bayar');
        });
    }
    public function down(): void { Schema::dropIfExists('pembayaran'); }
};
