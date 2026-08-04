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
        Schema::table('programs', function (Blueprint $table) {
            $table->date('tanggal_mulai')->nullable()->after('tahun');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('tanggal_selesai');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai', 'created_by']);
            $table->dropSoftDeletes();
        });
    }
};
