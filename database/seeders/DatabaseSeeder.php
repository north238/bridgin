<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(UserCommentSeeder::class);
        $this->call(ChartColorSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(AssetsSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(AssetTargetSeeder::class);
        $this->call(AssetChangesSeeder::class);
        $this->call(AssetSwitchStatusSeeder::class);
    }
}
