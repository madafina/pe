<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ExpenseCategory::insert([['name' => 'Gaji Karyawan & Tutor'], ['name' => 'Biaya Operasional Kantor'], ['name' => 'Pemasaran & Iklan'], ['name' => 'ATK & Kebutuhan Belajar'], ['name' => 'Lain-lain']]);
    }
}
