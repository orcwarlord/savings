<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add the first type
        Type::create([
            'name' => 'Bond',
        ]);

        // Add the second type
        Type::create([
            'name' => 'Current',
        ]);

        // Add the third type
        Type::create([
            'name' => 'ISA',
        ]);

        // Add the fourth type
        Type::create([
            'name' => 'Easy access',
        ]);

        // Add the fifth type
        Type::create([
            'name' => 'Online Saver',
        ]);
    }
}
