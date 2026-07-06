<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('employee_works', function (Blueprint $table) {
            // Tambahkan kolom tanggal setelah kolom 'month'
            $table->date('work_date')->nullable()->after('month');
        });
    }
    public function down(): void {
        Schema::table('employee_works', function (Blueprint $table) {
            $table->dropColumn('work_date');
        });
    }
};
