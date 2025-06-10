<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name' => 'Admin Penaemas',
            'email' => 'admin@bimbelpenaemas.id',
            'password' => Hash::make('rino'),
            'role' => 'admin',
        ]);

        // Akun Staf Keuangan
        User::create([
            'name' => 'Staf Keuangan',
            'email' => 'finance@bimbelpenaemas.id',
            'password' => Hash::make('penaemas'),
            'role' => 'finance',
        ]);
    }
}