<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Services\AssetService;

class DebutAssetController extends Controller
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
     * 負債データを取得する
     */
    public function debutAssetsIndex()
    {
        $userId = Auth::user()->id;
        $betweenMonthArray = $this->assetService->getCurrentMonth();
        $debutAssetData = $this->assets->getDebutAssetsData($userId, $betweenMonthArray)->get();

        return $this->debutAssetsShow($debutAssetData);
    }

    /**
     * 負債データを表示する
     */
    public function debutAssetsShow($debutAssetData)
    {
        return view('assets.debut-index', ['debutAssetData' => $debutAssetData]);
    }
}
