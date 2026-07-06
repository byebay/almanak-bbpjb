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
        Schema::create('public_access_logs', function (Blueprint $table) {
            $table->id();
            // Anda bisa menambahkan kolom lain jika perlu, seperti IP address atau user agent.
            // $table->string('ip_address')->nullable();
            // $table->string('user_agent', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_access_logs');
    }
};