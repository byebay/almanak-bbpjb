<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employee_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pegawai yang mengunggah
            $table->unsignedSmallInteger('year'); // Tahun laporan, misal: 2024
            $table->unsignedTinyInteger('month'); // Bulan laporan, 1-12
            $table->string('title'); // Judul pekerjaan/data
            $table->text('description')->nullable(); // Deskripsi singkat (opsional)
            $table->string('file_path'); // Lokasi file yang disimpan
            $table->string('file_type')->nullable(); // Tipe file, misal: 'pdf', 'jpg'
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('employee_works');
    }
};
