<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $comments = [
            [
                'comment' => '今月は使いすぎた。。。'
            ],
            [
                'comment' => 'もっと稼がなくてはな。'
            ]
        ];
        DB::table('comments')->insert($comments);
    }
}
