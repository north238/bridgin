<?php

namespace App\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Asset;

class AssetService
{

    private $assets;

    public function __construct(
        Asset $assets,
    ) {
        $this->assets = $assets;
    }

    /**
     * 資産を年月でグループ化する
     * @param \Illuminate\Support\Collection $data 資産のコレクション
     * @return array 年月でグループ化された結果の配列
     */
    public function groupByMonthOfRegistration($data)
    {
        $result = $data->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        return $result;
    }

    /**
     * 資産グループの合計金額と資産数を計算して新しい構造で返す
     * @param \Illuminate\Support\Collection $data 資産データのコレクション
     * @return \Illuminate\Support\Collection 合計金額と資産数を含む新しい構造のコレクション
     */
    public function processAssetGroups($data)
    {
        $result = $data->map(function ($group) {
            $totalAmount = $group->sum('amount');   // 合計金額を計算
            $assetCount = $group->count();          // 資産数をカウント

            return [
                'totalAmount' => $totalAmount,
                'assetCount' => $assetCount,
                'data' => $group
            ];
        });

        return $result;
    }

    /**
     * 最新月の増減額を取得する
     * @param  \Illuminate\Support\Collection $data 合計金額と資産数を含む新しい構造のコレクション
     * @return int $increaseDecreaseAmount 計算された資産増減額
     */
    public function getLatestMonthIncreaseDecreaseAmount($data)
    {
        $latestMonthData = $data->first();
        if (!isset($latestMonthData) === true) {
            return 0;
        }
        $latestMonthAmount = $latestMonthData['totalAmount'];
        $previousMonthData = $data->slice(1, 1)->first(); // 最後から2番目の月が前月のデータ
        $previousMonthAmount = $previousMonthData ? $previousMonthData['totalAmount'] : 0;
        $increaseDecreaseAmount =
            $latestMonthAmount - $previousMonthAmount;
        return $increaseDecreaseAmount;
    }

    /**
     * 負債合計額を取得する
     * @param  int  $userId
     * @param  bool $debutFlg
     * @return \Illuminate\Support\Collection 今月の負債額の合計
     */
    public function debutAmountDisplay($userId)
    {
        $sort =
            ['order' => 'registration_date', 'type' => 'DESC'];
        $betweenMonthArray = $this->getCurrentMonth();
        $assetData = $this->assets->fetchUserAssets($userId, $betweenMonthArray, $sort);
        $debutAssetData = $assetData->whereIn('g.id', [8])->get();
        $result = $debutAssetData->sum('amount');

        return $result;
    }

    /**
     * 今月の日付を取得する
     * @return Carbon $betweenMonthArray
     */
    public function getCurrentMonth()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $betweenMonthArray = [$startDate, $endDate];
        return $betweenMonthArray;
    }

    /**
     * フォーマットした日付を取得する
     * @return Carbon $formatDate
     */
    public function getFormatDate()
    {
        return Carbon::now()->format('Y-m');
    }
}
