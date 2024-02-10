<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(UserSeeder::class);
        $this->call(RiskSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(GenreRiskSeeder::class);
        // $this->call(CategorySeeder::class);
        $this->call(AssetsSeeder::class);
    }
}
