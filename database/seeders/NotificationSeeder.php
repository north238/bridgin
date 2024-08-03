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
                'body' => '資産管理を楽しみましょう！',
                'type' => 'info',
                'expires_at' => now()->addDays(7),
                'priority' => 1,
                'metadata' => json_encode(['key' => 'value']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '目標金額は？',
                'body' => '目標金額を決めることは大切です。',
                'type' => 'reminder',
                'expires_at' => now()->addDays(3),
                'priority' => 2,
                'metadata' => json_encode(['note' => 'check']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '皆さんこんにちは',
                'body' => '資産管理を楽しみましょう！',
                'type' => 'info',
                'expires_at' => now()->addDays(7),
                'priority' => 1,
                'metadata' => json_encode(['key' => 'value']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '目標金額は？',
                'body' => '目標金額を決めることは大切です。',
                'type' => 'reminder',
                'expires_at' => now()->addDays(3),
                'priority' => 2,
                'metadata' => json_encode(['note' => 'check']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '目標金額は？',
                'body' => '目標金額を決めることは大切です。',
                'type' => 'reminder',
                'expires_at' => now()->addDays(3),
                'priority' => 2,
                'metadata' => json_encode(['note' => 'check']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '目標金額は？',
                'body' => '目標金額を決めることは大切です。',
                'type' => 'reminder',
                'expires_at' => now()->addDays(3),
                'priority' => 2,
                'metadata' => json_encode(['note' => 'check']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('notifications')->insert($notifications);
    }
}
