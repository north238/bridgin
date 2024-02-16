<?php

namespace Database\Seeders;

use App\Models\UserComment;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userComments = [
            [
                'user_id' => 1,
                'comment_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'comment_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('user_comments')->insert($userComments);
    }
}
