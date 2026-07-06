<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            // Ganti nama kolom agenda_date menjadi start_date
            $table->renameColumn('agenda_date', 'start_date');
            
            // Tambahkan kolom baru untuk tanggal berakhir, boleh kosong (nullable)
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn('end_date');
            $table->renameColumn('start_date', 'agenda_date');
        });
    }
};