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
    Schema::table('creator_profiles', function (Blueprint $table) {
        $table->string('cover_image')->nullable()->after('profile_image');
        $table->string('phone')->nullable()->after('social_links');
    });
}

public function down(): void
{
    Schema::table('creator_profiles', function (Blueprint $table) {
        $table->dropColumn(['cover_image', 'phone']);
    });
}
};
