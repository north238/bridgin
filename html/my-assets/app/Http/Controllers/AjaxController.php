<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Carbon\Carbon;
use App\Services\AssetService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        $clickedBtn = $request['clicked-btn'];
        $prevMonthData = Carbon::parse($request['prev-month'])->format('Y-m-d');
        $nextMonthData = Carbon::parse($request['next-month'])->format('Y-m-d');
        $sort = ['order' => 'name', 'type' => 'ASC'];

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

        $assets = $this->assets->fetchUserAssets($userId, $betweenMonthArray, $sort)->get();
        $request['sort'] = $sort;
        $request['totalAmount'] = $assets->sum('amount');
        $request['assetsByMonth'] = $assets->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        return $this->ajaxPaginationShow($request, $userId);
    }

    /**
     * ページネーションを表示する
     * 
     */
    public function ajaxPaginationShow(Request $request, $userId)
    {
        $assetsByMonth = $request['assetsByMonth'];
        $totalAmount = $request['totalAmount'];
        $formatDate = Carbon::now()->format('Y-m');
        $assetMinDate = $this->assets->minAsset($userId);
        $assetMinDate = Carbon::parse($assetMinDate)->format('Y-m');
        $sort = $request['sort'];

        return view('assets.ajax_index', compact('assetsByMonth', 'totalAmount', 'formatDate', 'assetMinDate', 'sort'))->render();
    }

    /**
     * クリックされたカラムで昇順・降順を並び替え
     * 
     * @param Request $request
     * @return method $this->sortUpdate($request)
     */

    public function getSortFetchData(Request $request)
    {

        $sortType = $request->type;         // 昇順or降順(ソート)
        $sortNewOrder = $request->newOrder; // クリックされたaタグの名前

        $sortType = ($sortType === 'ASC') ? 'DESC' : 'ASC';
        $sort =
            ['order' => $sortNewOrder, 'type' => $sortType];

        return $this->PostSortData($sort);
    }

    /**
     * ソートされたデータをAssetsControllerへ送信する
     * @param object $sort
     * @return redirect
     */
    public function PostSortData($sort)
    {
        $userId = Auth::user()->id;
        $formatDate = Carbon::now()->format('Y-m');
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $betweenMonthArray = [$startDate, $endDate];

        $assets = $this->assets->fetchUserAssets($userId, $betweenMonthArray, $sort)->get();

        Session::put('monthData', $betweenMonthArray);
        Session::put('sortData', $sort);
        return view(
            'components.m_table_fetch_data',
            compact('assets', 'sort')
        );
    }
}
