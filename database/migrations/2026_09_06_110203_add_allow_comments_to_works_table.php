<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('works', function (Blueprint $table) {
            if (!Schema::hasColumn('works', 'allow_comments')) {
                $table->boolean('allow_comments')->default(true)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('works', function (Blueprint $table) {
            if (Schema::hasColumn('works', 'allow_comments')) {
                $table->dropColumn('allow_comments');
            }
        });
    }
};