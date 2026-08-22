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
    Schema::create('works', function (Blueprint $table) {
        $table->id();
        $table->foreignId('creator_id')->constrained('creator_profiles')->cascadeOnDelete();
        $table->foreignId('community_id')->nullable()->constrained()->nullOnDelete();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->string('category');
        $table->year('year');
        $table->string('location')->nullable();
        $table->longText('story')->nullable();
        $table->longText('process')->nullable();
        $table->enum('status', [
            'draft', 'submitted', 'under_review', 'needs_revision',
            'approved', 'published', 'rejected', 'archived'
        ])->default('draft');
        $table->string('cover_image')->nullable();
        $table->boolean('is_featured')->default(false);
        $table->timestamp('published_at')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('works');
}
};
