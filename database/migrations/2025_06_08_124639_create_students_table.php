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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('parent_phone_number');
            $table->enum('education_level', ['Pra-Sekolah', 'SD', 'SMP', 'SMA', 'Lulus/Umum']);
            $table->text('address')->nullable();
            $table->string('school_origin')->nullable();
            $table->date('registration_date');
            $table->enum('status', ['Aktif', 'Non-Aktif', 'Lulus', 'Berhenti'])->default('Non-Aktif'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
