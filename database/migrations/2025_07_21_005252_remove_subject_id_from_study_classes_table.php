<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('study_classes', function (Blueprint $table) {
            // Hapus foreign key constraint dulu agar tidak error
            $table->dropForeign(['subject_id']);

            // Baru hapus kolomnya
            $table->dropColumn('subject_id');
        });
    }

    public function down(): void
    {
        Schema::table('study_classes', function (Blueprint $table) {
            // Jika suatu saat perlu dibatalkan (rollback),
            // kita tambahkan kembali kolomnya
            $table->foreignId('subject_id')->nullable()->after('name')->constrained()->onDelete('set null');
        });
    }
};
