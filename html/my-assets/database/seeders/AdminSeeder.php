<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::truncate();

        Admin::create([
            'name' => '北山文哉',
            'email' => 'fumiyama02@yahoo.co.jp',
            'login_name' => 'f-kitayama',
            'password' => 'password123'
        ]);
    }
}
