<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mitra', function (Blueprint $t) {
            $t->id('id_mitra');
            $t->foreignId('id_user')->unique()->constrained('users', 'id_user')->cascadeOnDelete(); // users 1:1 mitra
            $t->string('nama_perusahaan');
            $t->enum('bentuk_usaha', ['PT', 'CV']);
            $t->string('alamat');
            $t->string('kontak');
            $t->enum('status_verifikasi', ['menunggu', 'terverifikasi', 'ditolak'])->default('menunggu');
        });
    }
    public function down(): void { Schema::dropIfExists('mitra'); }
};
