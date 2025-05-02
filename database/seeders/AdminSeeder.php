<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => Hash::make('password123'), // use a strong password in production
        ]);
    }
}
