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
    Schema::create('waste_dna', function (Blueprint $table) {
        $table->id();
        $table->foreignId('work_id')->constrained('works')->cascadeOnDelete();
        $table->string('material');
        $table->string('waste_type');
        $table->string('source')->nullable();
        $table->decimal('quantity', 10, 2)->nullable();
        $table->enum('unit', ['kg', 'g', 'item'])->nullable();
        $table->integer('item_count')->nullable();
        $table->string('processing_method')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('waste_dna');
}
};
