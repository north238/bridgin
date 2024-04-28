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

        $assetsAllData = $this->assets->getAssetsAllData($userId);
        if ($assetsAllData->count() === 0) {
            return redirect()->route('assets.yearly.index')->with('new-create-message', __('isEmpty_asset_error_message'));
        }

        $assetsByMonth = $this->assetService->groupByMonthOfRegistration($assetsAllData);
        $processedAssetGroups = $this->assetService->processAssetGroups($assetsByMonth);
        $totalAmounts = $processedAssetGroups->pluck('totalAmount')->first();
        $debutAssetTotalAmount = $this->assetService->debutAmountDisplay($userId);
        $latestMonthIncreaseDecreaseAmount = $this->assetService->getLatestMonthIncreaseDecreaseAmount($processedAssetGroups);

        $assetsData = [
            'assetsAllData' => $assetsAllData,
            'processedAssetGroups' => $processedAssetGroups,
            'totalAmounts' => $totalAmounts,
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
}
