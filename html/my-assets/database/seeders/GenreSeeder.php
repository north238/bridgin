<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Risk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            [
                'name' => '預貯金',
                'risk_rank' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '外貨資産',
                'risk_rank' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '現金（財布）',
                'risk_rank' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '暗号資産',
                'risk_rank' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '債券',
                'risk_rank' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '株式投資',
                'risk_rank' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '上場投資信託（ETF）',
                'risk_rank' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '負債',
                'risk_rank' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '実物資産',
                'risk_rank' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('genres')->insert($genres);
    }
}
