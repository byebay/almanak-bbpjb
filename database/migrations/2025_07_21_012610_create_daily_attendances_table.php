<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('ac_no'); // Akan diisi dari kolom "ID Pegawai" di Excel
            $table->string('employee_name'); // Akan diisi dari kolom "Nama" di Excel
            $table->date('date'); // Diambil dari input tanggal di form
            $table->time('check_in_time')->nullable(); // Dari kolom "MASUK"
            $table->time('check_out_time')->nullable(); // Dari kolom "KELUAR"
            $table->enum('status', ['Hadir', 'Terlambat', 'Cuti', 'Dinas Luar','Tanpa Keterangan'])->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('imported_by_user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_attendances');
    }
};
