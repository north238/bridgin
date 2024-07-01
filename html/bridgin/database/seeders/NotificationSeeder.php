<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'title' => '皆さんこんにちは',
                'body' => '資産管理を楽しみましょう！'
            ],
            [
                'title' => '目標金額は？',
                'body' => '目標金額を決めることは大切です。'
            ]
        ];
        DB::table('notifications')->insert($notifications);
    }
}
