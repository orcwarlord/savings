<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add the first user
        User::create([
            'name' => 'Martin',
            'email' => 'mhramiak@gmail.com',
            'password' => Hash::make('..Nosila1savings'), // Use Hash::make to securely hash the password
        ]);

        // Add the second user
        User::create([
            'name' => 'Alison',
            'email' => 'ajhramiak@gmail.com',
            'password' => Hash::make('..Nitram1savings'), // Use Hash::make to securely hash the password
        ]);
    }
}
