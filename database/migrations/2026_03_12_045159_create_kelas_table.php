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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 50); // Akan diisi otomatis: "X TKRO 1"
            $table->enum('tingkat', ['X', 'XI', 'XII']); // Kolom baru untuk tingkat
            $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
            $table->integer('rombel'); // Kolom baru untuk nomor rombel (1,2,3)
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->foreignId('wali_kelas_id')->nullable()->constrained('guru')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['jurusan_id', 'tahun_ajaran_id']);
            // Unique combination: tingkat + jurusan + rombel + tahun_ajaran
            $table->unique(['tingkat', 'jurusan_id', 'rombel', 'tahun_ajaran_id'], 'kelas_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
