<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Services\AssetService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\callback;

class AssetTrendController extends Controller
{
    private $assets;
    private $assetService;
    const SORT = ['order' => 'registration_date', 'type' => 'DESC'];

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
        $assetsYearlyData = $this->getAssetYearlyData();
        // グラフを表示
        $monthlyDoughnutChart = $this->createMonthlyDoughnutChart($assetsMonthlyData);
        $yearlyBarChart = $this->createYearlyBarChart($assetsYearlyData);
        $data = [
            'assetsMonthlyData' => $assetsMonthlyData,
            'yearlyBarChart' => $yearlyBarChart,
            'monthlyDoughnutChart' => $monthlyDoughnutChart
        ];

        return view('assets.trend-index', $data);
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
            ->type('pie')
            ->size(['width' => 100, 'height' => 100])
            ->datasets([
                [
                    'type' => 'pie',
                    'label' => 'カテゴリ（小分類）',
                    'data' => $assetsMonthlyData['categoryArrays'],
                    'backgroundColor' => $assetsMonthlyData['categoryColorArrays']
                ],
                [
                    'type' => 'pie',
                    'label' => 'ジャンル（大分類）',
                    'data' => $assetsMonthlyData['genreArrays'],
                    'backgroundColor' => $assetsMonthlyData['genreColorArrays']
                ]
            ])
            ->optionsRaw("{
                parsing: {
                    key: 'amount'
                },
                plugins: {
                    tooltip: {
                        enabled: true,
                        usePointStyle: true,
                        callbacks: {
                            labelPointStyle: function(context) {
                                return {
                                    pointStyle: 'pie'
                                };
                            },
                            title: function(context) {
                                const data = context[0].dataset.label;
                                return data;
                            },
                            label: function(context) {
                                let label = '';
                                const data = context.raw;
                                if (data) {
                                    const name = data.name;
                                    const amount = new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(data.amount);
                                    label = ['資産名：' + name, '金額：' + amount];
                                }
                                return label;
                            },
                            footer: function(context) {
                                const data = context[0].dataset.data;
                                const parsed = context[0].parsed;
                                const totalAmount = data.reduce((sum, item) => sum + item.amount, 0);
                                const ratio = Math.round((parsed / totalAmount) * 100);
                                const footer = '資産比率：' + ratio + '%';
                                return footer;
                            }
                        }
                    }
                }
            }");

        return $monthlyDoughnutChart;
    }

    /**
     * 資産データの取得(初期表示データ、負債データは除く)
     *
     * @param \Illuminate\Http\Request $request リクエスト
     * @return array $data 月間データの配列
     */
    public function getAssetMonthlyData(Request $request)
    {
        $userId = Auth::user()->id;
        $sort = self::SORT;

        // すべてのデータを取得
        $assetsData = $this->assets->fetchUserAssets($userId, $sort);
        // 負債データを取り除く
        $assetsData = $this->assets->filterAssetsByDebutData($assetsData);

        // 月指定がある場合
        if ($request->input('search-date')) {
            $betweenMonthArray = $this->searchAssetData($request);
        } else {
            $latestMonthDate = $this->assets->getLatestRegistrationDate($assetsData);
            $betweenMonthArray = $this->assetService->createSearchTargetMonth($latestMonthDate);
        }
        $assetsMonthlyData = $this->assets->filterAssetsByDateRange($assetsData, $betweenMonthArray)->get();

        // カテゴリ別の資産を取得（カテゴリ名、資産名、金額）
        $categoryData = $this->getAssetDataEachGenreCategory($assetsMonthlyData, 'category_name');
        $categoryArrays = $this->fetchGroupedArrayFromSpecifiedArray($categoryData, 'assetNamesArray', 'totalAmountArray', 'colorCodeArray');
        $categoryArrays = $this->combineArrays($categoryArrays);
        $categoryColorArrays = $this->fetchColorCodeFromArray($categoryArrays);

        // ジャンル別の資産を取得（ジャンル名、資産名、金額）
        $genreData = $this->getAssetDataEachGenreCategory($assetsMonthlyData, 'genre_name');
        $genreArrays = $this->combineKeysAndTotalAmounts($genreData);
        $genreColorArrays = $this->fetchColorCodeFromArray($genreArrays);

        // 資産合計額を取得
        $totalAmount =  $this->assets->calculateTotalAmount($assetsData);

        $data = [
            'totalAmount' => $totalAmount,
            'betweenMonthArray' => $betweenMonthArray,
            'assetsMonthlyData' => $assetsMonthlyData,
            'genreArrays' => $genreArrays,
            'genreColorArrays' => $genreColorArrays,
            'categoryArrays' => $categoryArrays,
            'categoryColorArrays' => $categoryColorArrays
        ];

        return $data;
    }

    /**
     * 資産の月を指定して表示する
     *
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
     * @return array 'name', 'amount'を持つ配列
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
    public function fetchColorCodeFromArray($arrays)
    {
        $colorCodeArrays = [];

        foreach ($arrays as $array) {
            $colorCodeArrays[] = $array['color_code'];
        }

        return $colorCodeArrays;
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
