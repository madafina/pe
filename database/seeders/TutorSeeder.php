<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Tutor;

class TutorSeeder extends Seeder
{
    public function run(): void
    {
        Tutor::insert([
            ['name' => 'Yaufani Adam', 'phone_number' => '081211112222', 'specialization' => 'Matematika, Fisika'],
            ['name' => 'Citra Ayu, M.Sc.', 'phone_number' => '081233334444', 'specialization' => 'Kimia, Biologi'],
            ['name' => 'Doni Saputra, S.S.', 'phone_number' => '081255556666', 'specialization' => 'Bahasa Indonesia, Sejarah'],
        ]);
    }
}