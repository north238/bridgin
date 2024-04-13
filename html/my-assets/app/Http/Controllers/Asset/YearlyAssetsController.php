<?php

namespace App\Http\Controllers\Asset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\User;
use App\Models\Category;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\AssetService;
use Illuminate\Support\Facades\DB;

class YearlyAssetsController extends Controller
{
    private $users;
    private $assets;
    private $assetService;

    public function __construct(
        Asset $assets,
        User $users,
        AssetService $assetService
    ) {
        $this->assets = $assets;
        $this->users = $users;
        $this->assetService = $assetService;
    }

    /**
     * 資産年間表示
     * 
     * @return View 
     */
    public function yearlyAssetsIndex()
    {
        $userId = Auth::user()->id;
        $sort = ['order' => 'registration_date', 'type' => 'DESC'];

        $assetsAllData = $this->assets->getAssetsAllData($userId, $sort);
        if ($assetsAllData->count() === 0) {
            return redirect()->route('assets.create')->with('new-create-message', 'あなたの新しい資産を追加しましょう');
        }

        $assetsByMonth = $assetsAllData->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        })->map(function ($group) {
            $totalAmount = $group->sum('amount'); // 合計金額を計算
            $assetCount = $group->count(); // 資産数をカウント

            return [
                'totalAmount' => $totalAmount,
                'assetCount' => $assetCount,
                'data' => $group // その他のデータ
            ];
        });

        $totalAmounts = $assetsByMonth->pluck('totalAmount');

        return view('assets.yearly_index', compact('assetsAllData', 'assetsByMonth', 'userId', 'totalAmounts'));
    }
}
