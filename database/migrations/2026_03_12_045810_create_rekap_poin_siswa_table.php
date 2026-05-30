<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekap_poin_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->integer('total_pelanggaran')->default(0);
            $table->integer('total_prestasi')->default(0);
            $table->integer('total_point_pelanggaran')->default(0);
            $table->integer('total_point_prestasi')->default(0);
            $table->integer('poin_bersih')->default(0)->comment('Prestasi - Pelanggaran');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['siswa_id', 'tahun_ajaran_id'], 'rekap_siswa_ta_unique');
            $table->index(['kelas_id', 'tahun_ajaran_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_poin_siswa');
    }
};
