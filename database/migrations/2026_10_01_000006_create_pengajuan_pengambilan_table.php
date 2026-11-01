<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_pengambilan', function (Blueprint $t) {
            $t->id('id_pengajuan');
            $t->foreignId('id_mitra')->constrained('mitra', 'id_mitra');                       // mitra 1:N pengajuan
            $t->foreignId('id_periode')->constrained('periode_pemeliharaan', 'id_periode');     // periode 1:N pengajuan
            $t->unsignedInteger('jumlah_diminta');
            $t->date('tgl_pengambilan');
            $t->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $t->timestamps(); // tambahan di luar ERD: dipakai untuk grafik "7 hari terakhir"
        });
    }
    public function down(): void { Schema::dropIfExists('pengajuan_pengambilan'); }
};
