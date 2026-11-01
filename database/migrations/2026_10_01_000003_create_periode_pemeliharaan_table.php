<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('periode_pemeliharaan', function (Blueprint $t) {
            $t->id('id_periode');
            $t->string('nama_periode');
            $t->date('tgl_mulai');
            $t->date('tgl_selesai');
            $t->unsignedInteger('jumlah_awal_ayam');
            $t->enum('status', ['direncanakan', 'berjalan', 'selesai'])->default('direncanakan');
        });
    }
    public function down(): void { Schema::dropIfExists('periode_pemeliharaan'); }
};
