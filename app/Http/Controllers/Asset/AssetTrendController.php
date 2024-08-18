<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Services\AssetService;
use App\Services\ChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @package App\Http\Controllers
 */
class AssetTrendController extends Controller
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

    /**
     * グラフ生成に関するデータを取得するサービス
     *
     * @var ChartService
     */
    private $chartService;

    /**
     * ソートのための定数
     *
     * @var array
     */
    const SORT = ['order' => 'registration_date', 'type' => 'DESC'];

    /**
     * @param Asset $assets 資産データのモデルインスタンス
     * @param AssetService $assetService 資産データを操作するサービス
     * @param ChartService $chartService グラフ生成に関するデータを取得するサービス
     */
    public function __construct(
        Asset $assets,
        AssetService $assetService,
        ChartService $chartService
    ) {
        $this->assets = $assets;
        $this->assetService = $assetService;
        $this->chartService = $chartService;
    }

    /**
     * 資産推移を表示する
     *
     * @param array[Carbon]|null $formatMonthDateBetween 検索対象の年月範囲
     * @param array[Carbon]|null $formatYearDateBetween 検索対象の年月範囲
     * @return \Illuminate\View\View 取得した変数の配列をビューに渡す
     */
    public function showAssetTrend($formatMonthDateBetween = null, $formatYearDateBetween = null)
    {
        // データを取得
        $assetsMonthlyData = $this->getAssetMonthlyData($formatMonthDateBetween);
        $assetsYearlyData = $this->getAssetYearlyData($formatYearDateBetween);
        $data = [
            'assetsMonthlyData' => $assetsMonthlyData,
            'assetsYearlyData' => $assetsYearlyData,
        ];

        return view('assets.trend-index', $data);
    }

    /**
     * 指定された月または年の範囲で資産データを検索し、結果を返します。
     *
     * - 指定された月がある場合、その月の範囲でデータを検索し、該当する年のデータも検索します。
     * - 指定された年がある場合、その年の範囲でデータを検索します。
     *
     * @param Illuminate\Http\Request $request 検索条件が含まれるリクエストオブジェクト
     * @return array $data 検索結果のデータ
     *     - 'formatMonthDateBetween': Carbonオブジェクトの配列（指定された月の範囲）
     *     - 'formatYearDateBetween': Carbonオブジェクトの配列（指定された年の範囲）
     */
    public function searchAssetData(Request $request)
    {
        $requestMonthDate = $request->input('search-month-date');
        $requestYearDate = $request->input('search-year-date');

        if (!empty($requestMonthDate)) {
            $formatMonthDateBetween = $this->assetService->createSearchTargetMonth($requestMonthDate);
            // 月間を検索するときは年間も検索させたいため追加
            $yearString = explode("-", $requestMonthDate)[0];
            $formatYearDateBetween = $this->assetService->getStartAndEndOfYear($yearString);

            return $this->showAssetTrend($formatMonthDateBetween, $formatYearDateBetween);
        }

        if (!empty($requestYearDate)) {
            $yearString = explode("-", $requestYearDate)[0];
            $formatYearDateBetween = $this->assetService->getStartAndEndOfYear($yearString);

            return
                $this->showAssetTrend(null, $formatYearDateBetween);
        }
    }

    /**
     * 資産データの取得(初期表示データ、負債データは除く)
     *
     * @param
     * @return array $data 月間データの配列
     */
    public function getAssetMonthlyData($betweenMonthArray)
    {
        $userId = Auth::user()->id;
        $sort = self::SORT;

        // すべてのデータを取得
        $assetsData = $this->assets->fetchUserAssets($userId, $sort);
        // 負債データを取り除く
        $assetsData = $this->assets->filterAssetsByDebutData($assetsData);

        // 月指定がある場合
        if (empty($betweenMonthArray)) {
            $latestMonthDate = $this->assets->getLatestRegistrationDate($assetsData);
            $betweenMonthArray = $this->assetService->createSearchTargetMonth($latestMonthDate);
        }
        $assetsMonthlyData = $this->assets->filterAssetsByDateRange($assetsData, $betweenMonthArray)->get();

        // カテゴリ別の資産を取得（カテゴリ名、資産名、金額）
        $categoryData = $this->chartService->getAssetDataEachGenreCategory($assetsMonthlyData, 'category_name');
        $categoryArrays = $this->chartService->fetchGroupedArrayFromSpecifiedArray($categoryData, 'assetNamesArray', 'totalAmountArray', 'colorCodeArray');
        $categoryArrays = $this->chartService->combineArrays($categoryArrays);
        $categoryColorArrays = $this->chartService->fetchColorCodeFromArray($categoryArrays, 'color_code');

        // ジャンル別の資産を取得（ジャンル名、資産名、金額）
        $genreData = $this->chartService->getAssetDataEachGenreCategory($assetsMonthlyData, 'genre_name');
        $genreArrays = $this->chartService->combineKeysAndTotalAmounts($genreData);
        $genreNameArrays = $this->chartService->fetchColorCodeFromArray($genreArrays, 'name');
        $genreColorArrays = $this->chartService->fetchColorCodeFromArray($genreArrays, 'color_code');

        // 資産合計額を取得
        $totalAmount =  $this->assets->calculateTotalAmount($assetsData);

        $data = [
            'totalAmount' => $totalAmount,
            'betweenMonthArray' => $betweenMonthArray,
            'assetsMonthlyData' => $assetsMonthlyData,
            'genreData' => $genreData,
            'genreArrays' => $genreArrays,
            'genreNameArrays' => $genreNameArrays,
            'genreColorArrays' => $genreColorArrays,
            'categoryArrays' => $categoryArrays,
            'categoryColorArrays' => $categoryColorArrays
        ];

        return $data;
    }

    /**
     * 年間データの取得
     *
     * @param
     * @return array $yearlyData グラフに表示するデータの配列
     */
    public function getAssetYearlyData($betweenMonthArray)
    {
        $userId = Auth::user()->id;
        $sort = self::SORT;

        // 全てのデータを取得
        $assetsAllData = $this->assets->fetchUserAssets($userId, $sort);

        // 検索があった場合
        if (empty($betweenMonthArray)) {
            $betweenMonthArray = $this->chartService->getDisplayYears($assetsAllData);
        }

        // 年間のすべての資産データを取得
        $assetsYearlyData = $this->assets->filterAssetsByDateRange($assetsAllData, $betweenMonthArray);
        $allMonths = $this->chartService->generateAllYearMonth($assetsYearlyData);
        $yearlyDataArray = $this->chartService->getChartDataForAssets($assetsYearlyData, $allMonths);

        // 年間の負債を除く資産データを取得
        $assetsData = $assetsYearlyData->whereNot('genre_id', 8);
        $assetsDataArray = $this->chartService->getChartDataForAssets($assetsData, $allMonths);

        // 年間の負債データを取得
        $debutDataArray = $this->chartService->formatDebutData($userId, $sort, $betweenMonthArray, $allMonths);

        $yearlyData = [
            'assetsYearlyData' => $assetsYearlyData->get(),
            'yearlyDataArray' => $yearlyDataArray,
            'assetsDataArray' => $assetsDataArray,
            'debutDataArray' => $debutDataArray,
            'betweenMonthArray' => $betweenMonthArray,
            'labels' => $allMonths
        ];

        return $yearlyData;
    }
}
