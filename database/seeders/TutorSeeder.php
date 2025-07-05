<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Tutor;

class TutorSeeder extends Seeder
{
    public function run(): void
    {
        Tutor::insert([
            ['name' => 'Emohi Rino Lailatul Kodar, ST', 'phone_number' => '081211112222', 'specialization' => 'Matematika, Fisika'],

        ]);
    }
}