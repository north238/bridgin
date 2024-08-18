<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notificationUser = [
            [
                'notification_id' => 1,
                'user_id' => 1,
                'read_at' => now(),
            ],
            [
                'notification_id' => 2,
                'user_id' => 1,
                'read_at' => null,
            ],
            [
                'notification_id' => 3,
                'user_id' => 1,
                'read_at' => now(),
            ],
            [
                'notification_id' => 4,
                'user_id' => 1,
                'read_at' => null,
            ],
            [
                'notification_id' => 5,
                'user_id' => 1,
                'read_at' => now(),
            ],
            [
                'notification_id' => 6,
                'user_id' => 1,
                'read_at' => null,
            ],
        ];
        DB::table('notification_user')->insert($notificationUser);
    }
}
