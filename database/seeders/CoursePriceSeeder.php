<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoursePrice;

class CoursePriceSeeder extends Seeder
{
    public function run(): void
    {
        CoursePrice::query()->delete(); // Hapus data lama dulu
        
         // Gelombang 1 (Early Bird untuk program Juli)
         CoursePrice::create(['course_id' => 1, 'price' => 1700000, 'name' => 'Gel. 1 (Juli-Sep)', 'registration_open_date' => '2025-03-01', 'registration_close_date' => '2025-09-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31']);
        CoursePrice::create(['course_id' => 2, 'price' => 2760000, 'name' => 'Gel. 1 (Juli-Sep)', 'registration_open_date' => '2025-03-01', 'registration_close_date' => '2025-09-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31']);
        CoursePrice::create(['course_id' => 2, 'price' => 3060000, 'name' => 'Gel. 1 (Juli-Sep)', 'registration_open_date' => '2025-03-01', 'registration_close_date' => '2025-09-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31']);
        CoursePrice::create(['course_id' => 2, 'price' => 3570000, 'name' => 'Gel. 1 (Juli-Sep)', 'registration_open_date' => '2025-03-01', 'registration_close_date' => '2025-09-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31']);

        // Gelombang 2 (untuk program Oktober)
        CoursePrice::create(['course_id' => 1, 'price' => 1445000, 'name' => 'Gel. 2 (Okt-Nov)', 'registration_open_date' => '2025-10-01', 'registration_close_date' => '2025-11-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31']);
        CoursePrice::create(['course_id' => 2, 'price' => 2346000, 'name' => 'Gel. 2 (Okt-Nov)', 'registration_open_date' => '2025-10-01', 'registration_close_date' => '2025-11-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31']);
        CoursePrice::create(['course_id' => 2, 'price' => 2601000, 'name' => 'Gel. 2 (Okt-Nov)', 'registration_open_date' => '2025-10-01', 'registration_close_date' => '2025-11-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31']);
        CoursePrice::create(['course_id' => 2, 'price' => 3034500, 'name' => 'Gel. 2 (Okt-Nov)', 'registration_open_date' => '2025-10-01', 'registration_close_date' => '2025-11-30', 'payment_notes' => 'Pembayaran hingga Desember 2025', 'payment_deadline' => '2025-12-31']);
       
        // Gelombang 3 (untuk program Desember)
        CoursePrice::create(['course_id' => 1, 'price' => 1190000, 'name' => 'Gel. 3 (Des-Juni)', 'registration_open_date' => '2025-12-01', 'registration_close_date' => '2026-06-30', 'payment_notes' => 'Pembayaran hingga Februari 2026', 'payment_deadline' => '2026-02-28']);
        CoursePrice::create(['course_id' => 2, 'price' => 1932000, 'name' => 'Gel. 3 (Des-Juni)', 'registration_open_date' => '2025-12-01', 'registration_close_date' => '2026-06-30', 'payment_notes' => 'Pembayaran hingga Februari 2026', 'payment_deadline' => '2026-02-28']);
        CoursePrice::create(['course_id' => 2, 'price' => 2142000, 'name' => 'Gel. 3 (Des-Juni)', 'registration_open_date' => '2025-12-01', 'registration_close_date' => '2026-06-30', 'payment_notes' => 'Pembayaran hingga Februari 2026', 'payment_deadline' => '2026-02-28']);
        CoursePrice::create(['course_id' => 2, 'price' => 2499000, 'name' => 'Gel. 3 (Des-Juni)', 'registration_open_date' => '2025-12-01', 'registration_close_date' => '2026-06-30', 'payment_notes' => 'Pembayaran hingga Februari 2026', 'payment_deadline' => '2026-02-28']);
        // ... (Lanjutkan untuk SMP & SMA Gel. 3)

         // Intensif UTBK
        CoursePrice::create(['course_id' => 5, 'price' => 1600000, 'name' => 'Intensif Januari', 'registration_open_date' => '2025-12-01', 'registration_close_date' => '2026-01-31', 'payment_notes' => 'Pembayaran hingga selesai', 'payment_deadline' => '2026-01-31']);
          
    }
}