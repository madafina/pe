<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoursePrice;

class CoursePriceSeeder extends Seeder
{
    public function run(): void
    {
        CoursePrice::query()->delete(); // Hapus data lama dulu

        CoursePrice::insert([
            ['course_id' => 1, 'price' => 1700000, 'valid_from' => '07-01', 'valid_until' => '09-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31'],
            ['course_id' => 1, 'price' => 1445000, 'valid_from' => '10-01', 'valid_until' => '11-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31'],
            ['course_id' => 1, 'price' => 1190000, 'valid_from' => '12-01', 'valid_until' => '06-30', 'payment_notes' => 'Pembayaran hingga Februari 2026', 'payment_deadline' => '2026-02-28'],
            // SD
            ['course_id' => 2, 'price' => 2760000, 'valid_from' => '07-01', 'valid_until' => '09-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31'],
            ['course_id' => 2, 'price' => 2346000, 'valid_from' => '10-01', 'valid_until' => '11-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31'],
            ['course_id' => 2, 'price' => 1932000, 'valid_from' => '12-01', 'valid_until' => '06-30', 'payment_notes' => 'Pembayaran hingga Februari 2026', 'payment_deadline' => '2026-02-28'],
            // SMP
            ['course_id' => 3, 'price' => 3060000, 'valid_from' => '07-01', 'valid_until' => '09-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31'],
            ['course_id' => 3, 'price' => 2601000, 'valid_from' => '10-01', 'valid_until' => '11-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31'],
            ['course_id' => 3, 'price' => 2142000, 'valid_from' => '12-01', 'valid_until' => '06-30', 'payment_notes' => 'Pembayaran hingga Februari 2026', 'payment_deadline' => '2026-01-31'],
            // SMA
            ['course_id' => 4, 'price' => 3570000, 'valid_from' => '07-01', 'valid_until' => '09-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31'],
            ['course_id' => 4, 'price' => 3034500, 'valid_from' => '10-01', 'valid_until' => '11-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31'],
            ['course_id' => 4, 'price' => 2499000, 'valid_from' => '12-01', 'valid_until' => '06-30', 'payment_notes' => 'Pembayaran hingga Februari 2026', 'payment_deadline' => '2026-01-31'],
            // Intensif UTBK
            ['course_id' => 5, 'price' => 1600000, 'valid_from' => '01-01', 'valid_until' => '01-31', 'payment_notes' => 'Pembayaran hingga selesai', 'payment_deadline' => '2026-01-31'],
        ]);
    }
}