<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = [
            [
                'name' => '銀行口座',
                'genre_id' => 1,
                'color_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '日本円',
                'genre_id' => 3,
                'color_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '投資信託(特別)',
                'genre_id' => 6,
                'color_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '投資信託(NISA)',
                'genre_id' => 6,
                'color_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '個別株',
                'genre_id' => 6,
                'color_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '外貨',
                'genre_id' => 2,
                'color_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bitcoin(BTC)',
                'genre_id' => 4,
                'color_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'アルトコイン',
                'genre_id' => 4,
                'color_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '金(GOLD)',
                'genre_id' => 9,
                'color_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '生命保険',
                'genre_id' => 9,
                'color_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '国債',
                'genre_id' => 5,
                'color_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '社債',
                'genre_id' => 5,
                'color_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '上場投資信託(海外)',
                'genre_id' => 7,
                'color_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '上場投資信託(国内)',
                'genre_id' => 7,
                'color_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '住宅ローン',
                'genre_id' => 8,
                'color_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'カーローン',
                'genre_id' => 8,
                'color_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'カードローン',
                'genre_id' => 8,
                'color_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '奨学金',
                'genre_id' => 8,
                'color_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('categories')->insert($categories);
    }
}
