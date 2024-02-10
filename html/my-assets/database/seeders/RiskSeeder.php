<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Risk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Risk::factory(10)->create();
    }
}
