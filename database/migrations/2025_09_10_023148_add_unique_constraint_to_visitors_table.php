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
        Schema::table('visitors', function (Blueprint $table) {
            // Terapkan aturan: kombinasi ip_address dan visit_date harus unik
            $table->unique(['ip_address', 'visit_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Perintah untuk membatalkan jika diperlukan
            $table->dropUnique(['ip_address', 'visit_date']);
        });
    }
};