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
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => '北山文哉',
            'email' => 'fumiyama02@yahoo.co.jp',
            'password' => static::$password ??= Hash::make('password')
        ];
        DB::table('users')->insert($user);
    }
}
