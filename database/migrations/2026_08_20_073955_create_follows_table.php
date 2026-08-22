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
    Schema::create('follows', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->enum('target_type', ['creator', 'community', 'material']);
        $table->unsignedBigInteger('target_id');
        $table->timestamps();

        $table->unique(['user_id', 'target_type', 'target_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('follows');
}
};
