<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 3 organisations, Newcastle Building Society, Santander, and Skipton Building Society
        Organisation::create([
            'name' => 'Newcastle Building Society',
            'url' => 'https://www.newcastle.co.uk',
        ]);

        Organisation::create([
            'name' => 'Santander',
            'url' => 'https://www.santander.co.uk',
        ]);

        Organisation::create([
            'name' => 'Skipton Building Society',
            'url' => 'https://www.skipton.co.uk',
        ]);

    }
}
