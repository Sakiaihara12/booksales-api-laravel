<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Test',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Customer Biasa',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password123'),
        ]);
    }
}