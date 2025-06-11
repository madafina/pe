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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_class_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('attendance_date');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa']);
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by_id')->constrained('users');
            $table->timestamps();
            // Menambahkan unique constraint untuk mencegah data ganda
            $table->unique(['study_class_id', 'student_id', 'attendance_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
