<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Services\AssetService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetTrendController extends Controller
{
    private $assets;
    private $assetService;
    const SORT = ['order' => 'registration_date', 'type' => 'ASC'];

    public function __construct(
        Asset $assets,
        AssetService $assetService
    ) {
        $this->assets = $assets;
        $this->assetService = $assetService;
    }

    /**
     * 資産推移を表示する
     * @param \Illuminate\Http\Request $request リクエスト
     * @return \Illuminate\View\View 取得した変数の配列をビューに渡す
     */
    public function showAssetTrend(Request $request)
    {
        // データを取得
        $assetsMonthlyData = $this->getAssetMonthlyData($request);
        $assetsYearlyData = $this->getAssetYearlyData($request);
        // グラフを表示
        $monthlyDoughnutChart = $this->createMonthlyDoughnutChart($assetsMonthlyData);
        $yearlyBarChart = $this->createYearlyBarChart($assetsYearlyData);
        $data = [
            'yearlyBarChart' => $yearlyBarChart,
            'monthlyDoughnutChart' => $monthlyDoughnutChart
        ];

        return view('assets.trend-index', $data);
    }

    /**
     * 資産の月を指定して表示する
     * @param Illuminate\Http\Request $request
     * @return array[Carbon] $formatDateBetween 年月の範囲
     */
    public function searchAssetData(Request $request)
    {
        $requestDate = $request->input('search-date');
        $formatDateBetween = $this->assetService->createSearchTargetMonth($requestDate);

        return $formatDateBetween;
    }

    /**
     * 月間チャートを生成
     * @param array $assetsMonthlyData 資産データの配列
     * @return \IcehouseVentures\LaravelChartjs\Builder $monthlyDoughnutChart 月間チャートオブジェクト
     */
    public function createMonthlyDoughnutChart($assetsMonthlyData)
    {
        $monthlyDoughnutChart =
            app()->chartjs
            ->name('monthlyChart')
            ->type('doughnut')
            ->size(['width' => 400, 'height' => 200])
            ->labels($assetsMonthlyData['assetNames'])
            ->datasets([
                [
                    'data' => $assetsMonthlyData['assetAmounts']
                ]
            ])
            ->options([
                "scales" => [
                    "y" => [
                        "display" => false
                    ]
                ],
                "plugins" => [
                    "legend" => [
                        "labels" => [
                            "font" => [
                                "size" => 10
                            ],
                            "padding" => 5,
                            "boxWidth" => 10
                        ],
                    ]
                ]
            ]);

        return $monthlyDoughnutChart;
    }

    /**
     * 資産データの取得(初期表示データ)
     * @param \Illuminate\Http\Request $request リクエスト
     * @return array $data 月間データの配列
     */
    public function getAssetMonthlyData(Request $request)
    {
        $userId = Auth::user()->id;
        $sort = self::SORT;

        // すべてのデータを取得
        $assetsData = $this->assets->fetchUserAssets($userId, $sort);

        // 月指定がある場合
        if ($request) {
            $betweenMonthArray = $this->searchAssetData($request);
        } else {
            $latestMonthDate = $this->assets->getLatestRegistrationDate($assetsData);
            $betweenMonthArray = $this->assetService->createSearchTargetMonth($latestMonthDate);
        }
        $assetsMonthlyData = $this->assets->filterAssetsByDateRange($assetsData, $betweenMonthArray)->get();

        // 各配列を取得
        $assetNames = $assetsMonthlyData->pluck('name')->all();
        $assetAmounts = $assetsMonthlyData->pluck('amount')->all();
        $assetTotalAmount = $assetsMonthlyData->sum('amount');

        $data = [
            'assetNames' => $assetNames,
            'assetAmounts' => $assetAmounts,
            'assetTotalAmount' => $assetTotalAmount,
            'assetsMonthlyData' => $assetsMonthlyData
        ];

        return $data;
    }

    /**
     * 年間チャートを生成
     *
     * @param array $assetsYearlyData 年間データの配列
     * @return \IcehouseVentures\LaravelChartjs\Builder $monthlyDoughnutChart 年間チャートオブジェクト
     */
    public function createYearlyBarChart($assetsYearlyData)
    {
        $yearlyBarChart = app()->chartjs
            ->name('yearlyChart')
            ->type('bar')
            ->size(['width' => 400, 'height' => 300])
            ->labels($assetsYearlyData['labels'])
            ->datasets([
                [
                    'type' => 'bar',
                    "label" => "資産",
                    'data' => $assetsYearlyData['assetsDataArray']
                ],
                [
                    'type' => 'bar',
                    "label" => "負債",
                    'data' => $assetsYearlyData['debutDataArray']
                ],
                [
                    'type' => 'line',
                    'label' => '資産合計',
                    'data' => $assetsYearlyData['yearlyDataArray']
                ]
            ])
            ->options([
                "scales" => [
                    "y" => [
                        'ticks' => [
                            'min' => 0 // 時系列
                        ]
                    ]
                ]
            ]);

        return $yearlyBarChart;
    }

    /**
     * 年間データの取得
     *
     * @return array $yearlyData グラフに表示するデータの配列
     */
    public function getAssetYearlyData()
    {
        $userId = Auth::user()->id;
        $sort = self::SORT;

        // 全てのデータを取得
        $assetsAllData = $this->assets->fetchUserAssets($userId, $sort);

        // 年間のすべての資産データを取得
        $allMonths = $this->generateAllYearMonth($assetsAllData);
        $yearlyDataArray = $this->getChartDataForAssets($assetsAllData, $allMonths);

        // 年間の負債を除く資産データを取得
        $assetsData = $assetsAllData->whereNot('genre_id', 8);
        $assetsDataArray = $this->getChartDataForAssets($assetsData, $allMonths);

        // 年間の負債データを取得
        $debutDataArray = $this->formatDebutData($userId, $sort, $allMonths);

        $yearlyData = [
            'yearlyDataArray' => $yearlyDataArray,
            'assetsDataArray' => $assetsDataArray,
            'debutDataArray' => $debutDataArray,
            'labels' => $allMonths
        ];

        return $yearlyData;
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
            $allMonths[] = $minDate->copy()->addMonths($i)->format('Y-m');
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
     * @param array $allMonths すべての年月を含む配列
     * @return array $debutDataArray 並び替え, 補完がされた負債データの配列
     */
    public function formatDebutData($userId, $sort, $allMonths)
    {
        $assetsData = $this->assets->fetchUserAssets($userId, $sort);
        $debutAssetData = $this->assets->getDebutAssetsData($assetsData);
        $debutDataArray = $this->getChartDataForAssets($debutAssetData, $allMonths);

        return $debutDataArray;
    }
}
