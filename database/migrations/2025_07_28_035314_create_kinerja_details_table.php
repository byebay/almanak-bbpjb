<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kinerja_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kinerja_id')->constrained()->onDelete('cascade');
            $table->string('pelaksana');
            $table->text('deskripsi_pekerjaan');
            $table->text('realisasi_target'); // Bisa numerik atau teks
            $table->text('progres_kegiatan');
            $table->text('kendala')->nullable();
            $table->text('strategi_penyelesaian')->nullable();
            $table->string('file_bukti')->nullable(); // Path ke file dokumentasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_details');
    }
};