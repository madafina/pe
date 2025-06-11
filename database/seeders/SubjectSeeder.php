<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        Subject::insert([
            ['name' => 'Matematika Wajib Kelas 10'],
            ['name' => 'Fisika Kelas 11'],
            ['name' => 'Kimia Kelas 12'],
            ['name' => 'Bahasa Indonesia'],
            ['name' => 'Calistung Baca'],
        ]);
    }
}