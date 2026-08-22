<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('submission_feedbacks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('work_id')->constrained('works')->cascadeOnDelete();
        $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
        $table->text('message');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('submission_feedbacks');
}
};
