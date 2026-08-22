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
    Schema::create('quiz_questions', function (Blueprint $table) {
        $table->id();
        $table->text('prompt');
        $table->json('options');
        $table->string('correct_option_id');
        $table->text('explanation')->nullable();
        $table->enum('status', ['draft', 'published'])->default('draft');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('quiz_questions');
}
};
