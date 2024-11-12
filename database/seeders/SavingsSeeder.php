<?php

namespace Database\Seeders;

use App\Models\Savings;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SavingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add the first savings
        Savings::create([
            'name' => "Martin's pension pot",
            'description' => 'Holiday to the Maldives',
            'amount' => 50000.00,
            'start_date' => '2024-11-11',
            'end_date' => '2025-11-11',
            'organisation_id' => 1,
            'saver' => 'Martin',
            // 'category_id' => 1,
            'is_active' => true,
            'is_fixed' => false,
            'interest_rate' => 0.00,
            'transfer_id' => null,
            'type_id' => 1,
        ]);

        // Add the second savings
        Savings::create([
            'name' => 'Car',
            'description' => 'New car',
            'amount' => 5000.00,
            'start_date' => '2024-11-11',
            'end_date' => '2024-11-11',
            'organisation_id' => 1,
            'saver' => 'Alison',
            // 'category_id' => 2,
            'is_active' => true,
            'is_fixed' => false,
            'interest_rate' => 0.00,
            'transfer_id' => null,
            'type_id' => 2,
        ]);
    }
}
