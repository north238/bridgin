<?php

namespace Database\Seeders;
use App\Models\GenreRisk;

use Database\Factories\GenreRiskFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreRiskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GenreRisk::factory(10)->create();
    }
}
