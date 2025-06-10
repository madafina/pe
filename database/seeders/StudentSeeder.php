<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Registration;
use App\Models\Invoice;
use App\Models\CoursePrice;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentNames = ['Fauzan Azhima', 'Haniina Hunafaa', 'Salmaan Shaalih', 'Eka Putri', 'Almahyra'];

        foreach ($studentNames as $name) {
            // 1. Ambil paket harga secara acak
            $coursePrice = CoursePrice::inRandomOrder()->first();

            // 2. Buat data siswa
            $student = Student::create([
                'full_name' => $name,
                'parent_phone_number' => '0812345678' . rand(10, 99),
                'address' => 'Jl. Merdeka No. ' . rand(1, 100),
                'school_origin' => 'Sekolah Harapan Bangsa',
                'registration_date' => now()->subDays(rand(1, 30)),
                'status' => 'Non-Aktif',
            ]);

            // 3. Buat data pendaftaran
            $registration = Registration::create([
                'student_id' => $student->id,
                'course_price_id' => $coursePrice->id,
                'transaction_date' => now(),
                'initial_payment_status' => 'Unpaid',
            ]);

            // 4. Buat invoice pertama
            Invoice::create([
                'registration_id' => $registration->id,
                'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad($registration->id, 5, '0', STR_PAD_LEFT),
                'description' => 'Biaya Pendaftaran Program ' . $coursePrice->course->name,
                'amount' => $coursePrice->price,
                'issue_date' => now(),
                'due_date' => now()->addDays(7),
                'status' => 'Unpaid',
            ]);
        }
    }
}