<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('kinerjas', function (Blueprint $table) { // BENAR
        $table->id();
        $table->foreignId('user_id')->constrained()->comment('Pegawai yang membuat laporan');
        $table->string('judul_kegiatan');
        $table->text('target_kinerja');
        $table->date('bulan_tahun')->comment('Untuk filter per bulan & tahun');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('kinerja');
    }
};