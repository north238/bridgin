<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    // テーブル上部にある日時のページネーション
    // ajaxによる非同期処理
    // クリックされたボタンにより表示する月を変更
    public function monthPagination(Request $request)
    {
        $userId = Auth::user()->id;
        $requestData = $request->all();
        $clickedBtn = $requestData['clicked-btn'];
        $prevMonthData = Carbon::parse($requestData['prev-month'])->format('Y-m-d');
        $nextMonthData = Carbon::parse($requestData['next-month'])->format('Y-m-d');
        $formatDate = Carbon::now()->format('Y-m');

        $assetMinDate = Asset::query()
            ->where('user_id', $userId)
            ->min('registration_date');
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

        $assets = Asset::query()
            ->where('user_id', $userId)
            ->with(['category:id,name'])
            ->whereBetween('registration_date', [$betweenMonthArray])
            ->get();
        $totalAmount = $assets->sum('amount');
        
        $assetsByMonth = $assets->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        return view('assets.ajax_index', compact('assetsByMonth', 'totalAmount', 'requestData', 'formatDate', 'assetMinDate' ))->render();
    }

    /**
     * 昇順降順を非同期で実装
     * aタグをクリックしたら処理が走る
     * すべての昇順降順切り替えのための関数
     * ajaxで現状を取得する、データを並び替える、現在のデータを取得
     * →ソート専用のルートへ何がソートされるのかを送信
     * →Ajaxで実現したい（理由: 他の機能が壊れてしまうから）
     * data-sortに情報を送信する？
     * →バックに送信するにはセッションかAjax
     * セッションを使う？
     * →状態はどうやって確認する？
     * →jsで取得？セッションを送信する？
     * 
     */

    public function sortable() {

        $userId = Auth::user()->id;
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $assets = Asset::query()
            ->where('user_id', $userId)
            ->with(['category:id,name'])
            ->whereBetween('registration_date', [$startDate, $endDate])
            ->get();

        $assets->orderBy('registration_date', 'desc');

        return view('assets.index', compact('assets'));
    }
}
