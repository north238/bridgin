<?php

namespace App\Http\Controllers\Asset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Asset;
use App\Services\AssetService;

class YearlyAssetsController extends Controller
{
    private $assets;
    private $assetService;

    public function __construct(
        Asset $assets,
        AssetService $assetService
    ) {
        $this->assets = $assets;
        $this->assetService = $assetService;
    }

    /**
     * 資産年間表示
     * @return \Illuminate\View\View 表示されるビュー
     */
    public function yearlyAssetsIndex()
    {
        $userId = Auth::user()->id;
        $sort = ['order' => 'registration_date', 'type' => 'DESC'];

        $assetsAllData = $this->assets->fetchUserAssets($userId, $sort);

        // すべてのデータを取得
        $displayAllData = $this->assets->getAssetsPagination($userId)->paginate(10);
        $totalCount = $this->assets->calculateTotalCount($assetsAllData);
        $latestMonthDate = $this->assets->getLatestRegistrationDate($assetsAllData);
        $formatDate = $this->assetService->getFormatYearMonth($latestMonthDate);

        // 最新月のデータを取得
        $monthlyAssetsData = $this->getAssetsMonthlyData($userId, $sort);
        $monthlyTotalAmount = $this->assets->calculateTotalAmount($monthlyAssetsData);
        $latestMonthIncreaseDecreaseAmount = $this->assetService->getLatestMonthIncreaseDecreaseAmount($assetsAllData, $latestMonthDate, $monthlyTotalAmount);

        // 負債額の合計を取得(条件を絞るため資産データを再取得する)
        $debutAssetTotalAmount = $this->assetService->debutAmountDisplay($userId, $sort, $latestMonthDate);

        $assetsData = [
            'displayAllData' => $displayAllData,
            'totalCount' => $totalCount,
            'formatDate' => $formatDate,
            'latestMonthDate' => $latestMonthDate,
            'monthlyTotalAmount' => $monthlyTotalAmount,
            'debutAssetTotalAmount' => $debutAssetTotalAmount,
            'latestMonthIncreaseDecreaseAmount' => $latestMonthIncreaseDecreaseAmount,
        ];

        return $this->yearlyAssetsShow($assetsData);
    }

    /**
     * 資産を表示する
     * @param array $assetsData 年次の資産データ
     * @return \Illuminate\View\View 表示されるビュー
     */
    public function yearlyAssetsShow($assetsData)
    {
        return view('assets.yearly-index', $assetsData);
    }

    /**
     * 月間の資産データを取得
     * @param int $userId 資産を取得するユーザーのID
     * @param array $sort 資産を取得する際の並び替え基準
     */
    public function getAssetsMonthlyData($userId, $sort)
    {
        $assetsData = $this->assets->fetchUserAssets($userId, $sort);
        $latestMonthDate = $this->assets->getLatestRegistrationDate($assetsData);
        $betweenMonthArray = $this->assetService->createSearchTargetMonth($latestMonthDate);
        $assetsMonthlyData = $this->assets->filterAssetsByDateRange($assetsData, $betweenMonthArray)->get();

        return $assetsMonthlyData;
    }
}
