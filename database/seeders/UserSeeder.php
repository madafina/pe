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
            'email' => 'admin@bimbelpenaemas.com',
            'password' => Hash::make('penaemas'),
        ]);

        // Akun Staf Keuangan
        User::create([
            'name' => 'Staf Keuangan',
            'email' => 'finance@bimbelpenaemas.com',
            'password' => Hash::make('penaemas'),
        ]);
    }
}