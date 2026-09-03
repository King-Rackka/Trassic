<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('waste_dna', function (Blueprint $table) {
            // "Bahan pendukung" - list bahan tambahan (stearin, sumbu, pewangi, dst)
            // disimpan sebagai JSON array of string, bukan tabel terpisah, karena
            // sifatnya cuma daftar teks pendek, nggak butuh query/relasi sendiri.
            $table->json('supporting_materials')->nullable()->after('processing_method');

            // "Hasil pemanfaatan" - deskripsi singkat hasil akhir (misal "Lilin aromaterapi/dekoratif")
            $table->string('usage_result')->nullable()->after('supporting_materials');
        });
    }

    public function down(): void
    {
        Schema::table('waste_dna', function (Blueprint $table) {
            $table->dropColumn(['supporting_materials', 'usage_result']);
        });
    }
};