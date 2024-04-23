<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetTrendController extends Controller
{
    /**
     * 資産推移を表示する
     */
    public function showAssetTrend()
    {
        return view('assets.trend-index');
    }

    /**
     * ユーザーが操作した処理を実行する
     */
    public function processAssetData()
    {

    }
}
