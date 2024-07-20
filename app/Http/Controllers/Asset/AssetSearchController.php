<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetSearchRequest;
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
    public function receiveSearchRequest(AssetSearchRequest $request)
    {
        $validated = $request->validated();
        $requestFormDate = $validated['search-date'];
        $debutStatus = $validated['debutStatus'];
        $debutSearchFlg = $validated['debut-search-flg'];

        if(empty($requestFormDate)) {
            return back()->with(['error-message' => '資産の検索に失敗しました。入力値をご確認ください。']);
        }

        $formatDateBetween = $this->assetService->createSearchTargetMonth($requestFormDate);
        if ($debutSearchFlg === "1") {
            return $this->searchDebutAssets($requestFormDate, $formatDateBetween);
        }

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
     * 検索対象の負債データを表示
     *
     * @param  string $requestFormDate   フォームから送信された日付
     * @param array $formatDateBetween フォーマットされた日付の配列
     * @return Illuminate\Contracts\View\View 資産の検索結果を表示するビュー
     */
    public function searchDebutAssets($requestFormDate, $formatDateBetween)
    {
        $userId = Auth::user()->id;
        $sort =
            ['order' => 'registration_date', 'type' => 'DESC'];

        $assetData = $this->assets->fetchUserAssets($userId, $sort);
        $debutAssetData = $this->assets->getDebutAssetsData($assetData, $formatDateBetween)->get();
        $totalCount = $this->assets->calculateTotalCount($debutAssetData);
        $debutTotalAmount = $this->assets->calculateTotalAmount($debutAssetData);

        $debutAssetData = [
            'latestMonthDate' => $requestFormDate,
            'debutAssetData' => $debutAssetData,
            'debutTotalAmount' => $debutTotalAmount,
            'totalCount' => $totalCount
        ];

        return view('assets.debut-index', $debutAssetData);
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
