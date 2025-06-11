<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\StudyClass;

class StudyClassSeeder extends Seeder
{
    public function run(): void
    {
        StudyClass::insert([
            [
                'name' => 'Fisika 11A - Sore',
                'subject_id' => 2, // Merujuk ke Fisika Kelas 11
                'tutor_id' => 1,   // Merujuk ke Budi Setiawan
                'day_of_week' => 'Selasa',
                'start_time' => '16:00:00',
                'end_time' => '17:30:00',
            ],
            [
                'name' => 'Kimia 12 Intensif - Pagi',
                'subject_id' => 3, // Merujuk ke Kimia Kelas 12
                'tutor_id' => 2,   // Merujuk ke Citra Ayu
                'day_of_week' => 'Sabtu',
                'start_time' => '09:00:00',
                'end_time' => '10:30:00',
            ],
        ]);
    }
}