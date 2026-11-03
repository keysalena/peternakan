<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $t) {
            $t->dateTime('diambil_pada')->nullable()->after('tgl_transaksi'); // diisi saat QR nota dipindai / dikonfirmasi admin
        });
    }
    public function down(): void
    {
        Schema::table('transaksi', fn (Blueprint $t) => $t->dropColumn('diambil_pada'));
    }
};
