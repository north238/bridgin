<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Carbon\Carbon;
use App\Services\AssetService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    private $assets;
    private $assetService;

    public function __construct(Asset $assets, AssetService $assetService)
    {
        $this->assets = $assets;
        $this->assetService = $assetService;
        // $this->authorizeResource(Asset::class, 'assets');
    }

    /**
     * テーブル上部にある日時のページネーション
     * ajaxによる非同期処理
     * クリックされたボタンにより表示する月を変更
     * 
     * @param Request $request
     * @return Json
     */
    public function ajaxPaginationIndex(Request $request)
    {
        $userId = Auth::user()->id;
        $requestData = $request->all();
        $clickedBtn = $requestData['clicked-btn'];
        $prevMonthData = Carbon::parse($requestData['prev-month'])->format('Y-m-d');
        $nextMonthData = Carbon::parse($requestData['next-month'])->format('Y-m-d');
        $formatDate = Carbon::now()->format('Y-m');
        $sortData = ['order' => 'name', 'type' => 'ASC'];

        $assetMinDate = $this->assets->minAsset($userId);
        $assetMinDate = Carbon::parse($assetMinDate)->format('Y-m');

        if ($clickedBtn === 'prev-month-btn') {
            // 前月
            $betweenMonthArray = [
                Carbon::parse($prevMonthData)->startOfMonth(),
                Carbon::parse($prevMonthData)->endOfMonth()
            ];
        } elseif ($clickedBtn === 'next-month-btn') {
            // 翌月
            $betweenMonthArray = [
                Carbon::parse($nextMonthData)->startOfMonth(),
                Carbon::parse($nextMonthData)->endOfMonth()
            ];
        } else {
            // 今月
            $betweenMonthArray = [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ];
        }

        session()->put('month-data', $betweenMonthArray);

        $assets = $this->assets->assetsQuery($userId, $betweenMonthArray, $sortData);
        $totalAmount = $assets->sum('amount');

        $assetsByMonth = $assets->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        return view('assets.ajax_index', compact('assetsByMonth', 'totalAmount', 'requestData', 'formatDate', 'assetMinDate', 'sortData'))->render();
    }

    /**
     * クリックされたカラムで昇順・降順を並び替え
     * 
     * @param Request $request
     * @return method $this->sortUpdate($request)
     */

    public function sortIndex(Request $request)
    {
        $sortOrder = $request->order;       // 何を（カラム名）
        $sortType = $request->type;         // 昇順or降順(ソート)
        $sortNewOrder = $request->newOrder; // クリックされたaタグの名前

        if(isset($sortNewOrder) === true) {
            $sortType = ($sortType === 'ASC') ? 'DESC' : 'ASC';
            $sortData =
            ['order' => $sortNewOrder, 'type' => $sortType];
        } else {
            $sortData =
                ['order' => $sortOrder, 'type' => $sortType];
        }

        session()->put('sort-data', $sortData); 

        return $this->sortUpdate($request);
    }

    /**
     * SortIndexから受け取った値でデータを書き換える
     * ソートされたデータをajaxへ送信する
     * 
     * @param Request $request
     * @return json
     */
    public function sortUpdate(Request $request) 
    {
        $userId = Auth::user()->id;
        $requestData = $request->all();
        $formatDate = Carbon::now()->format('Y-m');

        if (session()->has('sort-data') === true) {
            $sortData = session()->get('sort-data');
            session()->forget('sort-data');
        } else {
            $sortData = ['order' => 'name', 'type' => 'ASC'];
        }

        if (session()->has('month-data') === true) {
            $betweenMonthArray = session()->get('month-data');
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $betweenMonthArray = [$startDate, $endDate];
        }
        
        $assetMinDate = $this->assets->minAsset($userId);
        $assetMinDate = Carbon::parse($assetMinDate)->format('Y-m');

        $assets = $this->assets->assetsQuery($userId, $betweenMonthArray, $sortData);
        $totalAmount = $assets->sum('amount');
        $assetsByMonth = $assets->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        return view('assets.ajax_index', compact('assetsByMonth', 'totalAmount', 'requestData', 'formatDate', 'assetMinDate', 'sortData'))->render();
    }
}
