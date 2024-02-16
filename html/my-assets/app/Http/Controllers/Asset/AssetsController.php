<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;

class AssetsController extends Controller
{
    /**
     * 資産表示画面（ログイン済かつ作成したユーザーのみ）
     * 登録内容をテーブルで表示させる
     * 
     */
    public function index()
    {
        // 直近の30日間のデータを取得
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $user = Auth::user();

        $assets = Asset::with(['category:id,name'])
            ->whereBetween('registration_date', ['2023-10-01', '2023-11-01'])
            ->get();

        $totalAmount = Asset::whereBetween('registration_date', ['2023-10-01', '2023-11-01'])->sum('amount');
        // dd($totalAmount);

        // $assets = Asset::whereBetween('registration_date', ['2023-10-01', '2023-11-01'])->get();
        return view('assets.index', compact('assets', 'totalAmount'));
    }

    /**
     * 資産登録画面
     */
    public function create()
    {
        //
    }

    /**
     * 資産をデータベースに保存
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 資産詳細画面
     */
    public function show(string $id)
    {
        //
    }

    /**
     * 資産編集画面表示
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * 資産更新
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * 資産削除
     */
    public function destroy(string $id)
    {
        //
    }
}
