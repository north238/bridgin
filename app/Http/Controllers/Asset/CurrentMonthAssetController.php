<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use App\Services\AssetService;

class CurrentMonthAssetController extends Controller
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
     * 増減額データの取得
     */
    public function currentMonthAssetsIndex()
    {
        $userId = Auth::user()->id;
        $sort = ['order' => 'registration_date', 'type' => 'DESC'];

        $assetsAllData = $this->assets->fetchUserAssets($userId, $sort);
        $assetsByMonthData = $this->assetService->groupByMonthOfRegistration($assetsAllData);
        $processAssetGroups = $this->assetService->processAssetGroups($assetsByMonthData);
        $monthOverMonthRatios = $this->assetService->calcMonthOverMonthRatios($processAssetGroups);
        // 資産が登録されていない場合は、エラーメッセージを表示
        if($monthOverMonthRatios->isEmpty()) {
            return redirect()->route('assets.dashboard')->with('error-message', '現在、登録されている資産はありません。');
        }

        $latestTotalAmount = $monthOverMonthRatios->last()['totalAmount'];
        $firstMonth = $monthOverMonthRatios->first()['month'];
        $lastMonth = $monthOverMonthRatios->last()['month'];

        $data = [
            'monthOverMonthRatios' => $monthOverMonthRatios,
            'latestTotalAmount' => $latestTotalAmount,
            'firstMonth' => $firstMonth,
            'lastMonth' => $lastMonth
        ];

        return $this->currentMonthAssetsShow($data);
    }

    /**
     * 増減額データの表示
     */
    public function currentMonthAssetsShow($data)
    {
        return view('assets.current-month-index', $data);
    }
}
