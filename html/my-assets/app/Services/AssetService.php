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
     * @return \Illuminate\Support\Collection 年月でグループ化された結果
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
        $betweenMonthArray = $this->getCurrentMonth();
        $debutAssetData = $this->assets->getDebutAssetsData($userId, $betweenMonthArray);
        $result = $debutAssetData->sum('amount');

        return $result;
    }

    /**
     * 負債の表示/非表示切替
     * @param int 　$debutStatus 負債を表示するかどうかを示すステータス
     * @param int 　$userId 資産を取得するユーザーのID
     * @param array $sort 資産を取得する際の並び替え基準
     * @return \Illuminate\Support\Collection ステータスに応じて負債の表示/非表示が切り替えられた資産のコレクション
     */
    public function switchDebutVisibility($debutStatus, $userId, $sort)
    {
        if (isset($debutStatus) === true && $debutStatus === 1) {
            //　負債を非表示にする処理（ジャンルが負債のものを除外）
            $debutFlg = true;
            $assetAllData = $this->assets->fetchUserAssets($userId, $sort, $debutFlg);
        } else {
            $assetAllData = $this->assets->fetchUserAssets($userId, $sort);
        }

        return $assetAllData;
    }

    /**
     * 現在の年月を取得する（データ取得時のwhereBetweenで使用）
     * @return Carbon $betweenMonthArray
     */
    public function getCurrentMonth()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->startOfMonth();
        $betweenMonthArray = [$startDate, $endDate];
        return $betweenMonthArray;
    }

    /**
     * 取得した日時から検索対象の年月を作成
     * @param  string $date
     * @return Carbon $betweenMonthArray
     */
    public function createSearchTargetMonth($date)
    {
        $startDate = Carbon::parse($date)->startOfMonth();
        $endDate = Carbon::parse($date)->endOfMonth();
        $betweenMonthArray = [$startDate, $endDate];
        return $betweenMonthArray;
    }

    /**
     * フォーマットした現在の日付を取得する
     * @return Carbon $formatDate
     */
    public function getFormatDate()
    {
        return Carbon::now()->format('Y-m-d');
    }

    /**
     * 取得した年月を変換する
     * @param  string $date
     * @return string $formatDate 型変換された日付
     */
    public function getFormatMonthDate($date)
    {
        $carbonDate = Carbon::createFromFormat('Y-m', $date);
        $formatDate = $carbonDate->format('Y-m-01');
        return $formatDate;
    }

    /**
     * 登録前のバリデーション処理
     * @param $request
     * @param $userId
     */
    public function assetDataValidated($request, $userId)
    {
        $asset = $this->assets;
        $validated = $request->validated();
        $asset->name = $validated['name'];
        $asset->amount = $validated['amount'];
        $asset->registration_date = $validated['registration_date'];
        $asset->category_id = $validated['category_id'];
        $asset->asset_type_flg = $validated['asset_type_flg'];
        $asset->user_id = $userId;

        return $asset;
    }
}
