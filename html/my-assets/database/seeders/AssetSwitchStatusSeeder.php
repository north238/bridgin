<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetSwitchStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $assetSwitchStatus = [
                [
                    'user_id' => 1,
                    'debut_status' => 1,
                    'asset_type_status' => 1
                ],
                [
                    'user_id' => 2,
                    'debut_status' => 0,
                    'asset_type_status' => 1
                ],
                [
                    'user_id' => 3,
                    'debut_status' => 1,
                    'asset_type_status' => 1
                ],
                [
                    'user_id' => 4,
                    'debut_status' => 0,
                    'asset_type_status' => 1
                ],
                [
                    'user_id' => 5,
                    'debut_status' => 1,
                    'asset_type_status' => 1
                ],

            ];
            DB::table('asset_switch_statuses')->insert($assetSwitchStatus);
        }
    }
}
