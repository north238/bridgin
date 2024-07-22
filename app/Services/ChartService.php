<?php

namespace App\Services;

use App\Models\Asset;
use App\Services\AssetService;

class ChartService
{
    /**
     * 資産データのモデルインスタンス
     *
     * @var Asset
     */
    private $assets;

    /**
     * 資産データを操作するサービス
     *
     * @var AssetService
     */
    private $assetService;

    public function __construct(
        Asset $assets,
        AssetService $assetService
    ) {
        $this->assets = $assets;
        $this->assetService = $assetService;
    }

    /**
     * 動的に選択されたフィールドの資産データを取得する
     *
     * @param \Illuminate\Support\Collection $data 選択された資産データのコレクション
     * @param string $field グループ化したいフィールド
     * @return \Illuminate\Support\Collection $amountsByField 資産名, 合計金額, フィールド合計金額がまとめられたデータ
     */
    public function getAssetDataEachGenreCategory($data, $field)
    {
        // フィールド名でグループ化
        $groupedByField = $data->groupBy(function ($asset) use ($field) {
            return $asset->{$field};
        });

        $amountsByField = $groupedByField->map(function ($group) {
            $totalAmountArray = $group->pluck('amount')->all();
            $assetNamesArray = $group->pluck('name')->all();
            $colorCodeArray = $group->pluck('color_code')->all();
            $fieldTotalAmountArray = $group->sum('amount');

            return [
                'totalAmountArray' => $totalAmountArray,
                'assetNamesArray' => $assetNamesArray,
                'colorCodeArray' => $colorCodeArray,
                'fieldTotalAmountArray' => $fieldTotalAmountArray
            ];
        });

        return $amountsByField;
    }

    /**
     * グループ化された配列から指定した配列を取り出す
     *
     * @param \Illuminate\Support\Collection $arrayData 資産名, 合計金額, フィールド合計金額がまとめられたデータ
     * @param string $dataField 指定したいフィールド
     * @return array $fetchArrays 指定して取り出した配列
     */
    public function fetchGroupedArrayFromSpecifiedArray($arrayData, $dataNameField, $dataAmountField, $colorCodeArray)
    {
        $fetchArrays = [];
        foreach ($arrayData as $array) {
            $fetchArrays[] = [
                'name' => $array[$dataNameField],
                'amount' => $array[$dataAmountField],
                'color_code' => $array[$colorCodeArray]
            ];
        }

        return $fetchArrays;
    }

    /**
     * 2つの配列を結合する
     *
     * @param array $arrays 2つの配列
     * @return array
     */
    public function combineArrays($arrays)
    {
        $combinedArray = [];

        foreach ($arrays as $array) {
            foreach ($array['name'] as $index => $name) {
                $combinedArray[] = [
                    'name' => $name,
                    'amount' => $array['amount'][$index],
                    'color_code' => $array['color_code'][$index]
                ];
            }
        }

        return $combinedArray;
    }

    /**
     * 配列のキーと合計資産額を結合する
     *
     * @param array $arrays キーと'fieldTotalAmountArray'値を含む連想配列
     * @return array $combinedArray 資産名、金額、カラーコードを持つ配列
     */
    public function combineKeysAndTotalAmounts($arrays)
    {
        $combinedArray = [];

        foreach ($arrays as $key => $value) {
            $combinedArray[] = [
                'name' => $key,
                'amount' => $value['fieldTotalAmountArray'],
                'color_code' => $value['colorCodeArray'][0]
            ];
        }

        return $combinedArray;
    }

    /**
     * 配列からカラーコードを取り出す
     *
     * @param array $arrays 資産名、金額、カラーコードを含む配列
     * @return array $colorCodeArrays カラーコードの配列
     */
    public function fetchColorCodeFromArray($arrays, $field)
    {
        $colorCodeArrays = [];

        foreach ($arrays as $array) {
            $colorCodeArrays[] = $array[$field];
        }

        return $colorCodeArrays;
    }

    /**
     * 表示する年を取得する
     * @param string $date 年月日
     * @return array [Carbon] 年月の範囲
     */
    public function getDisplayYears($data)
    {
        $latestMonthDate = $this->assets->getLatestRegistrationDate($data);
        $yearString = explode("-", $latestMonthDate)[0];

        $betweenMonthArray = $this->assetService->getStartAndEndOfYear($yearString);

        return $betweenMonthArray;
    }

    /**
     * すべての年月を含む配列を生成する
     *
     * @param \Illuminate\Support\Collection $assetsData 資産データのコレクション
     * @return array $allMonths すべての年月を含む配列
     */
    public function generateAllYearMonth($assetsData)
    {
        // 最大月と最小月を取得
        $maxDate = $this->assetService->formaDate($assetsData->max('registration_date'));
        $minDate = $this->assetService->formaDate($assetsData->min('registration_date'));

        $allMonths = [];
        $diffInMonths = $minDate->diffInMonths($maxDate) + 1;

        for ($i = 0; $i < $diffInMonths; $i++) {
            $allMonths[] = $minDate->copy()->addMonths($i)->format('n');
        }

        return $allMonths;
    }

    /**
     * グラフ表示に必要な資産データを取得する
     *
     * @param \Illuminate\Support\Collection $data 資産データのコレクション
     * @param array $allMonths すべての月の配列
     * @return array グラフ表示用の資産総額の配列
     */
    public function getChartDataForAssets($data, $allMonths)
    {
        $complementedAssetData = $this->assetService->registeredAssetDataComplement($data, $allMonths);
        $groupedAssetData = $this->assetService->processAssetGroups($complementedAssetData);
        $totalAmounts = $groupedAssetData->pluck('totalAmount')->all();

        return $totalAmounts;
    }

    /**
     * 負債データを整形
     *
     * @param string $userId ユーザーID
     * @param array $sort ソート条件(['order' => 'registration_date', 'type' => 'DESC'])
     * @param array [Carbon] 年月の範囲
     * @param array $allMonths すべての年月を含む配列
     * @return array $debutDataArray 並び替え, 補完がされた負債データの配列
     */
    public function formatDebutData($userId, $sort, $betweenMonthArray, $allMonths)
    {
        $assetsData = $this->assets->fetchUserAssets($userId, $sort);
        $debutAssetData = $this->assets->getDebutAssetsData($assetsData, $betweenMonthArray);
        $debutDataArray = $this->getChartDataForAssets($debutAssetData, $allMonths);

        return $debutDataArray;
    }
}
