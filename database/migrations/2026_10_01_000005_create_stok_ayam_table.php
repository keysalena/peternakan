<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stok_ayam', function (Blueprint $t) {
            $t->id('id_stok');
            $t->foreignId('id_periode')->unique()->constrained('periode_pemeliharaan', 'id_periode')->cascadeOnDelete(); // periode 1:1 stok
            $t->unsignedInteger('jumlah_tersedia');
            $t->dateTime('tgl_update');
        });
    }
    public function down(): void { Schema::dropIfExists('stok_ayam'); }
};
