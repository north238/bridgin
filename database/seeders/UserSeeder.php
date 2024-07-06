<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => '北山文哉',
            'email' => 'fumiyama02@yahoo.co.jp',
            'password' => 'password123'
        ];
        DB::table('users')->insert($user);

        User::factory()->count(20)->create();
    }
}
