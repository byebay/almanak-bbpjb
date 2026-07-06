<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('shared_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('url');
            $table->integer('year');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('shared_links');
    }
};