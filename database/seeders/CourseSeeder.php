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
            ['name' => 'Calistung', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Elementary School', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Middle School', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'High School', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'UTBK Intensive', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
