<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            [
                'color_code' => '#22C55E',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color_code' => '#0EA5E9',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color_code' => '#3B82F6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color_code' => '#FBBF24',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color_code' => '#818CF8',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color_code' => '#E879F9',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color_code' => '#FB7185',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color_code' => '#F87171',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color_code' => '#FDE047',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('chart_colors')->insert($colors);
    }
}
