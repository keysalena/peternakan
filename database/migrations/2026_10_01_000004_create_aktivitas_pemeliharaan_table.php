<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aktivitas_pemeliharaan', function (Blueprint $t) {
            $t->id('id_aktivitas');
            $t->foreignId('id_periode')->constrained('periode_pemeliharaan', 'id_periode')->cascadeOnDelete(); // periode 1:N aktivitas
            $t->date('tanggal');
            $t->string('jenis_aktivitas');
            $t->unsignedInteger('mortalitas')->default(0);
            $t->text('catatan')->nullable();
        });
    }
    public function down(): void { Schema::dropIfExists('aktivitas_pemeliharaan'); }
};
