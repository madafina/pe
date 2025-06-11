<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        Subject::query()->delete(); // Hapus data lama
        Subject::insert([
            ['name' => 'Calistung Baca Tulis', 'course_id' => 1], // Course ID 1 adalah Calistung
            ['name' => 'Matematika SD Kelas 4', 'course_id' => 2], // Course ID 2 adalah SD
            ['name' => 'IPA Terpadu SMP', 'course_id' => 3], // Course ID 3 adalah SMP
            ['name' => 'Fisika Kelas 11', 'course_id' => 4], // Course ID 4 adalah SMA
            ['name' => 'Kimia Kelas 12', 'course_id' => 4], // Course ID 4 adalah SMA
            ['name' => 'TPS Kuantitatif UTBK', 'course_id' => 5], // Course ID 5 adalah Intensif UTBK
        ]);
    }
}