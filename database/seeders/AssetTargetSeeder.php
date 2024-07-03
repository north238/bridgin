<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assetChanges = [
            [
                'user_id' => 1,
                'target_asset' => 2000000,
                'target_date' => '2024-04-29',
                'status' => 0,
                'description' => '車購入資金',
            ],
            [
                'user_id' => 1,
                'target_asset' => 5000000,
                'target_date' => '2025-04-29',
                'status' => 2,
                'description' => '結婚資金',
            ],
        ];
        DB::table('asset_targets')->insert($assetChanges);
    }
}
