<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Asset;
use App\Services\AssetService;

class AssetSearchController extends Controller
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
     * 検索のリクエストを受け取る
     * @param  Request $request
     * @return \Illuminate\View\View 検索結果の表示ビュー
     */
    public function receiveSearchRequest(Request $request)
    {
        $requestFormDate = $request->input('form-date');
        $debutStatus = $request->input('debutStatus');
        $formatDateBetween = $this->assetService->createSearchTargetMonth($requestFormDate);

        return $this->displaySearchResults($requestFormDate, $formatDateBetween, $debutStatus);
    }

    /**
     * 指定された条件で資産を検索する。
     *
     * @param array $formatDateBetween フォーマットされた日付の配列
     * @param int   $debutStatus       負債を表示するかどうかを示すステータス
     * @return \Illuminate\Support\Collection 検索した資産のコレクション
     */
    public function searchAssets($formatDateBetween, $debutStatus)
    {
        $userId = Auth::user()->id;
        $sort =
            ['order' => 'registration_date', 'type' => 'DESC'];
        $assetsData = $this->assetService->switchDebutVisibility($debutStatus, $userId, $sort);
        $assetsData = $this->assets->filterAssetsByDateRange($assetsData, $formatDateBetween)->get();

        return $assetsData;
    }

    /**
     * 検索結果を表示する。
     *
     * @param  string $requestFormDate   フォームから送信された日付
     * @param  array  $formatDateBetween フォーマットされた日付の配列
     * @param  string $debutStatus       負債を表示するかどうかを示すステータス
     * @return Illuminate\Contracts\View\View 資産の検索結果を表示するビュー
     */
    public function displaySearchResults($requestFormDate, $formatDateBetween, $debutStatus)
    {

        $assetsData = $this->searchAssets($formatDateBetween, $debutStatus);
        $totalCount = $assetsData->count('id');
        $totalAmount = $assetsData->sum('amount');

        $data = [
            'assetsData' => $assetsData,
            'totalAmount' => $totalAmount,
            'totalCount' => $totalCount,
            'latestMonthDate' => $requestFormDate,
            'debutStatus' => $debutStatus
        ];

        return view('assets.index', $data);
    }
}
