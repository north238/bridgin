<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetChangesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assetChanges = [
            [
                'asset_id' => 1,
                'user_id' => 1,
                'changed_type_flg' => 1,
                'changed_fields' => json_encode([
                    'name' => ['old' => 'Old Name', 'new' => 'New Name'],
                    'amount' => ['old' => 1000, 'new' => 1500]
                ]),
                'changed_time' => '2024-03-30',
                'ip_address' => '192.168.1.102'
            ],
            [
                'asset_id' => 2,
                'user_id' => 1,
                'changed_type_flg' => 0,
                'changed_fields' => json_encode([
                    'name' => ['new' => 'Asset Name'],
                    'amount' => ['new' => 2000]
                ]),
                'changed_time' => '2024-03-30',
                'ip_address' => '192.168.1.102'
            ],
            [
                'asset_id' => 3,
                'user_id' => 1,
                'changed_type_flg' => 1,
                'changed_fields' => json_encode([
                    'name' => ['old' => 'Asset Name'],
                    'amount' => ['old' => 2000]
                ]),
                'changed_time' => '2024-03-30',
                'ip_address' => '192.168.1.102'
            ]

        ];
        DB::table('asset_changes')->insert($assetChanges);
    }
}
