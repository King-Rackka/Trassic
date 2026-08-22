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
    Schema::create('educational_contents', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->enum('type', ['dictionary', 'article']);
        $table->text('description')->nullable();
        $table->longText('content')->nullable();
        $table->string('image')->nullable();
        $table->enum('status', ['draft', 'published'])->default('draft');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('educational_contents');
}
};
