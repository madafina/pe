<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Course::insert([
            ['name' => 'Pra Sekolah', 'required_level' => 'Pra-Sekolah', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sekolah Dasar', 'required_level' => 'SD', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sekolah Menengah Pertama', 'required_level' => 'SMP', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sekolah Menengah Atas', 'required_level' => 'SMA', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'UTBK Intensive', 'required_level' => 'Lulus/Umum', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
