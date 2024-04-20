<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Services\AssetService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssetRestoreController extends Controller
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
     * 削除された資産一覧の表示
     * @return View
     */
    public function showDeletedAssets()
    {
        $userId = Auth::user()->id;
        $restoreAssetsData = $this->assets->getRestoreAssets($userId);
        // ddd($restoreAssetsData);
        if (count($restoreAssetsData) === 0) {
            return back()->with('error-message', "削除されたデータは見つかりませんでした。");
        }
        return view('assets.restore', ['restoreAssetsData' => $restoreAssetsData]);
    }

    /**
     * 削除された資産の復元
     * @param string $id
     * @return Route assets.index
     */
    public function restoreAsset(string $id)
    {
        $asset = Asset::withTrashed()->findOrFail($id);

        try {
            DB::beginTransaction();
            $asset->restore();
            DB::commit();

            return redirect()->route('assets.index')->with('success-message', '削除したデータの復元に成功しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error-message', '削除したデータの復元に失敗しました。' . $e->getMessage());
        }
    }
}
