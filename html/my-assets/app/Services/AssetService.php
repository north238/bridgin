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
     * @param $data 資産のコレクション
     * @return \Illuminate\Support\Collection 年月でグループ化された結果
     */
    public function groupByMonthOfRegistration($data)
    {
        $assetData = $data->get();
        $result = $assetData->groupBy(function ($asset) {
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
     * @param  \Illuminate\Support\Collection $assetsAllData 資産データのコレクション
     * @param  string $latestMonthDate 最新の年月
     * @param  int $monthlyTotalAmount 月間の合計金額
     * @return int $increaseDecreaseAmount 計算された資産増減額
     */
    public function getLatestMonthIncreaseDecreaseAmount($assetsAllData, $latestMonthDate, $monthlyTotalAmount)
    {
        // 資産データがなければ0を返却
        if (empty($assetsAllData) === true) {
            return 0;
        }
        // ひと月前の日時を取得
        $previousMonthDate = $this->getPreviousMonthDate($latestMonthDate);
        // ひと月前のデータを取得
        $betweenMonthArray = $this->createSearchTargetMonth($previousMonthDate);
        $previousMonthData = $this->assets->filterAssetsByDateRange($assetsAllData, $betweenMonthArray);
        // ひと月前のデータがない場合の条件分岐
        if (!empty($previousMonthData) === true) {
            $previousMonthAmount = $this->assets->calculateTotalAmount($previousMonthData);
        } else {
            $previousMonthAmount = 0;
        }
        $increaseDecreaseAmount =
            $monthlyTotalAmount - $previousMonthAmount;

        return $increaseDecreaseAmount;
    }

    /**
     * 負債合計額を取得する
     * @param  int  $userId    資産を取得するユーザーのID
     * @param  bool $debutFlg  負債を判断するためのフラグ
     * @return \Illuminate\Support\Collection 今月の負債額の合計
     */
    public function debutAmountDisplay($userId, $sort, $latestMonthDate)
    {
        $assetData = $this->assets->fetchUserAssets($userId, $sort);
        $betweenMonthArray = $this->createSearchTargetMonth($latestMonthDate);
        $debutAssetData = $this->assets->getDebutAssetsData($assetData, $betweenMonthArray);
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
            $assetAllData = $this->assets->fetchUserAssets($userId, $sort, null, $debutFlg);
        } else {
            $assetAllData = $this->assets->fetchUserAssets($userId, $sort, null);
        }

        return $assetAllData;
    }

    /**
     * 現在の年月を取得する（データ取得時のwhereBetweenで使用）
     * @return array [Carbon] 現在の年月の範囲
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
     * @@return array [Carbon] 現在の年月の範囲
     */
    public function createSearchTargetMonth($date)
    {
        $startDate = Carbon::parse($date)->startOfMonth();
        $endDate = Carbon::parse($date)->endOfMonth();
        $betweenMonthArray = [$startDate, $endDate];
        return $betweenMonthArray;
    }

    /**
     * 現在の日付を指定されたフォーマットで取得
     *
     * @return string フォーマットされた現在の日付
     */
    public function getFormatDate()
    {
        return Carbon::now()->format('Y-m-d');
    }

    /**
     * 取得した年月を変換する
     * @param  string $date
     * @return string $formatDate フォーマットされた年月
     */
    public function getFormatMonthDate($date)
    {
        $carbonDate = Carbon::createFromFormat('Y-m', $date);
        $formatDate = $carbonDate->format('Y-m-01');

        return $formatDate;
    }

    /**
     * ひと月前の日付に変換する
     * @param  string $date 年月日を取得
     * @return string $formatDate フォーマットされた年月
     */
    public function getPreviousMonthDate($date)
    {
        $carbonDate = Carbon::parse($date);
        $previousMonthDate =
            $carbonDate->subMonth()->format('Y-m-01');

        return $previousMonthDate;
    }

    /**
     * 資産データのバリデーションを行います。
     *
     * @param Illuminate\Http\Request $request リクエストオブジェクト
     * @param int $userId 資産を登録するユーザーのID
     * @return App\Models\Asset バリデーション済みの資産データ
     */
    public function assetDataValidated($asset, $validated, $userId)
    {
        $asset->name = $validated['name'];
        $asset->amount = $validated['amount'];
        $asset->registration_date = $validated['registration_date'];
        $asset->category_id = $validated['category_id'];
        $asset->asset_type_flg = $validated['asset_type_flg'];
        $asset->user_id = $userId;

        return $asset;
    }
}
