<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reporter_id')->nullable()->constrained('users')->nullOnDelete();
        $table->foreignId('work_id')->constrained('works')->cascadeOnDelete();
        $table->string('reason');
        $table->text('message')->nullable();
        $table->enum('status', ['open', 'reviewed', 'dismissed'])->default('open');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('reports');
}
};
