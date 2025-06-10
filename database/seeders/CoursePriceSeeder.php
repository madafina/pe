<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\CoursePrice::insert([
            // Calistung
            ['course_id' => 1, 'enrollment_period' => 'July', 'price' => 1700000, 'payment_notes' => 'Payment until December 2025'],
            ['course_id' => 1, 'enrollment_period' => 'October', 'price' => 1445000, 'payment_notes' => 'Payment until December 2025'],
            ['course_id' => 1, 'enrollment_period' => 'December', 'price' => 1190000, 'payment_notes' => 'Payment until February 2026'],
            // Elementary School
            ['course_id' => 2, 'enrollment_period' => 'July', 'price' => 2760000, 'payment_notes' => 'Payment until December 2025'],
            ['course_id' => 2, 'enrollment_period' => 'October', 'price' => 2346000, 'payment_notes' => 'Payment until December 2025'],
            ['course_id' => 2, 'enrollment_period' => 'December', 'price' => 1932000, 'payment_notes' => 'Payment until February 2026'],
            // Middle School
            ['course_id' => 3, 'enrollment_period' => 'July', 'price' => 3060000, 'payment_notes' => 'Payment until December 2025'],
            ['course_id' => 3, 'enrollment_period' => 'October', 'price' => 2601000, 'payment_notes' => 'Payment until December 2025'],
            ['course_id' => 3, 'enrollment_period' => 'December', 'price' => 2142000, 'payment_notes' => 'Payment until February 2026'],
            // High School
            ['course_id' => 4, 'enrollment_period' => 'July', 'price' => 3570000, 'payment_notes' => 'Payment until December 2025'],
            ['course_id' => 4, 'enrollment_period' => 'October', 'price' => 3034500, 'payment_notes' => 'Payment until December 2025'],
            ['course_id' => 4, 'enrollment_period' => 'December', 'price' => 2499000, 'payment_notes' => 'Payment until February 2026'],
            // UTBK Intensive
            ['course_id' => 5, 'enrollment_period' => 'January', 'price' => 1600000, 'payment_notes' => 'Full payment'],
        ]);
    }
}
